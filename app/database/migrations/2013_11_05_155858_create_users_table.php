<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('publishersnew', function(Blueprint $table)
		{
			
			    $table->increments('id');
                $table->string('firstname', 20);
                $table->string('lastname', 20);
                $table->text('resume')->nullable();
                $table->text('description')->nullable();
                $table->string('MfiNumber')->nullable();
                $table->string('MfiPin')->nullable();
                $table->string('msisdn', 100)->unique();
                $table->string('email', 100)->unique();
                $table->boolean('active');
                $table->string('password');
                $table->boolean('isadmin')->default(false);
                $table->string('remember_token',100)->nullable();
                $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('publishersnew');
	}

}
