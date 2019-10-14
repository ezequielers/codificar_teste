<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RedeModel extends Model
{
    protected $table = 'redes';
    protected $primaryKey = 'id_rede';

    protected $casts = ['id_deputado' => 'int'];

    protected $fillable = [
        'id_deputado'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deputado()
    {
        return $this->belongsTo(DeputadoModel::class);
    }

}
