<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
			// THE ADMIN
			[
				'email'  	=> 'nombre@institucion.gob.do',
				'password'  => Hash::make('123456'),
				'name'      => 'Nombre Apellido',
				'charge'    => 'Cargo',
				'phone'     => '2484841506',
				'user_type' => 'government',
				'is_admin'  => TRUE
			],
			[
				'email'  	=> 'nombre.apellido@institucion.gob.do',
				'password'  => Hash::make('123456'),
				'name'      => 'Nombre Apellido',
				'charge'    => 'Cargo',
				'phone'     => '2484841506',
				'user_type' => 'government',
				'is_admin'  => FALSE
			],
			[
				'email'  	=> 'nombre@gmail.com',
				'password'  => Hash::make('123456'),
				'name'      => 'Nombre Apellido',
				'charge'    => 'Cargo',
				'phone'     => '2484841506',
				'user_type' => 'society',
				'is_admin'  => FALSE
			]
		]);
    }
}
