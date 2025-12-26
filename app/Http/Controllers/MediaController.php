<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMediaRequest;
use App\Http\Resources\MediaResource;
use App\Models\Media;
use App\Models\Request as WorkRequest;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    // GET /api/requests/{id}/media
    public function index(HttpRequest $r, $id)
    {
        $user = $r->user();
        $req  = WorkRequest::findOrFail($id);

        // السماح: Tenant صاحب الطلب، أو Technician المعيّن، أو Admin
        if (!($req->tenant_id === $user->id
            || $req->technician_id === $user->id
            || $user->role === 'admin')) {
            return $this->response(null, 'Forbidden', 403);
        }

        $items = $req->media()->latest()->get();

        return $this->response($items);
    }

    // POST /api/requests/{id}/media  (multipart/form-data: type, image)
    public function store(StoreMediaRequest $r, $id)
    {
        $user = $r->user();
        $req  = WorkRequest::findOrFail($id);
        $data = $r->validated(); 

        // الصلاحيات حسب النوع
        if ($data['type'] === 'before') {
            // فقط صاحب الطلب (Tenant)
            if (!($user->role === 'tenant' && $req->tenant_id === $user->id)) {
                return $this->response(null, 'Only the tenant can upload BEFORE images for this request', 403);
            }
            
        } else { // after
            // فقط الفني المعيّن
            if (!($user->role === 'technician' && $req->technician_id === $user->id)) {
                return $this->response(null, 'Only the assigned technician can upload AFTER images', 403);
            }
           if ($data['type'] === 'after') {
                if (!in_array($req->status, ['complete'])) {
                      return $this->response(null, 'You can upload AFTER only after complete', 422);
    }
} 
            
        }

        // حفظ الملف: storage/app/public/requests/{id}/{type}/filename.ext
        $path = $r->file('image')->store("/requests/{$req->id}/{$data['type']}", 'public' );
        $url  = Storage::url($path); // /storage/requests/{id}/{type}/...

        $media = $req->media()->create([
            'type' => $data['type'],
            'url'  => $url,
        ]);

        return $this->response(new MediaResource($media), 'Uploaded', 201);

    }

    // DELETE /api/media/{id}
    public function destroy(HttpRequest $r, $id)
    {
        $user  = $r->user();
        $media = Media::findOrFail($id);
        $req   = $media->request;

        // سماح بالحذف:
        // - tenant صاحب الطلب لو type=before (افتراضًا صوره)
        // - technician المعيّن لو type=after (افتراضًا صوره)
        // - admin دائمًا
        $allowed = false;

        if ($user->role === 'admin') {
            $allowed = true;
        } elseif ($media->type === 'before' && $user->role === 'tenant' && $req->tenant_id === $user->id) {
            $allowed = true;
        } elseif ($media->type === 'after' && $user->role === 'technician' && $req->technician_id === $user->id) {
            $allowed = true;
        }

        if (!$allowed) {
            return $this->response(null, 'Forbidden', 403);
        }

        // احذف الملف من التخزين (اختياري لكنه أفضل)
        if ($media->url) {
            // $media->url = /storage/...
            // حوّلها لمسار في disk:
            $relative = str_replace('/storage/', 'public/', $media->url);
            Storage::delete($relative);
        }

        $media->delete();

        return $this->response(null, 'Deleted');
    }
}
