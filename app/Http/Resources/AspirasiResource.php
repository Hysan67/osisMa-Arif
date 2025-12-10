<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AspirasiResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nama' => $this->nama,
            'kelas' => $this->kelas,
            'email' => $this->email,
            'judul' => $this->judul,
            'pesan' => $this->pesan,
            'balasan' => $this->balasan,
            'status' => $this->status,
            'status_label' => ucfirst($this->status),
            'email_sent' => $this->email_sent,
            'email_sent_at' => $this->email_sent_at?->format('Y-m-d H:i:s'),
            'email_sent_formatted' => $this->email_sent_at?->format('d/m/Y H:i'),
            'admin' => $this->admin ? [
                'id' => $this->admin->id,
                'name' => $this->admin->name,
                'email' => $this->admin->email,
            ] : null,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'created_at_formatted' => $this->created_at->format('d/m/Y H:i'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'is_menunggu' => $this->status === 'menunggu',
            'has_email' => !empty($this->email),
        ];
    }
}