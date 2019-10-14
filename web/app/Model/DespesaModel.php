<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DespesaModel extends Model
{
    protected $table = 'despesa';
    protected $primaryKey = 'id_despesa';

    protected $casts = ['id_deputado' => 'int'];

    public $timestamps = true;

    protected $fillable = [
        'id_deputado',
        'valor',
        'mes',
        'ano'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deputado()
    {
        return $this->belongsTo(DeputadoModel::class);
    }

}
