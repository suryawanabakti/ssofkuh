<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $password = (string) str()->uuid();

        $user =  new User([
            'name' => $row[1],
            'username' => $row[2],
            'password' => bcrypt($password),
            'temporary_password' => $password,
            'token' => str()->uuid()
        ]);

        $user->assignRole('user');

        return $user;
    }
}
