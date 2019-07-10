<?php

/**
 * Modèle de la table Ticket
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'Ticket';
    protected $primaryKey = 'ID';
    public $timestamps = false;  //Ne pas gérer nous même les timestamps
}
