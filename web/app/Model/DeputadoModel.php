<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DeputadoModel extends Model
{
    protected $table = 'deputado';
    protected $primaryKey = 'id_deputado';

    public $timestamps = true;

    protected $fillable = [
        'id_deputado',
        'nome',
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function despesas()
    {
        return $this->hasMany(DespesaModel::class, 'id_deputado');
    }

}
