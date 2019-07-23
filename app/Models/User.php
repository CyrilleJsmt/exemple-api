<?php

/**
 * Modèle de la table User
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'User';
    protected $primaryKey = 'ID';

    public function getAuthIdentifierName() {
        return 'ID';
      }
    
      public function getAuthIdentifier() {
        return $this->{$this->getAuthIdentifierName()};
      }
    
      public function getAuthPassword() {
        return $this->{'Password'};
      }
    
      public function getRememberToken()
      {
        if (! empty($this->getRememberTokenName())) {
          return $this->{$this->getRememberTokenName()};
        }
      }
    
      public function setRememberToken($value)
      {
        if (! empty($this->getRememberTokenName())) {
          $this->{$this->getRememberTokenName()} = $value;
        }
      }
    
      public function getRememberTokenName()
      {
        return $this->rememberTokenName;
      }
}
