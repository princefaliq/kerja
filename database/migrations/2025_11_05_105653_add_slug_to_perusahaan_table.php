<?php

use App\Models\Perusahaan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AddSlugToPerusahaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('perusahaan', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable()->after('user_id');
        });
        // isi slug untuk data lama
        /*$perusahaans = Perusahaan::with('user')->get();

        foreach ($perusahaans as $p) {
            if ($p->user && $p->alamat) {
                $baseSlug = Str::slug($p->user->name . ' ' . $p->alamat);
                $slug = $baseSlug;
                $count = 1;

                // pastikan slug unik
                while (Perusahaan::where('slug', $slug)->exists()) {
                    $count++;
                    $slug = "{$baseSlug}-{$count}";
                }

                $p->slug = $slug;
                $p->save();
            }
        }*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('perusahaan', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
}
