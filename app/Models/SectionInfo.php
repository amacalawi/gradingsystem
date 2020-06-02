<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionInfo extends Model
{
    protected $guarded = ['id'];

    protected $table = 'sections_info';
    
    public $timestamps = false;

    public function fetch($id)
    {
        $sectioninfos = self::find($id);
        if ($sectioninfos) {
            $results = array(
                'id' => ($sectioninfos->id) ? $sectioninfos->id : '',
                'batch_id' => ($sectioninfos->batch_id) ? $sectioninfos->batch_id : '',
                'section_id' => ($sectioninfos->section_id) ? $sectioninfos->section_id : '',
                'adviser_id' => ($sectioninfos->adviser_id) ? $sectioninfos->adviser_id : '',
                'level_id' => ($sectioninfos->level_id) ? $sectioninfos->level_id : '',
                'type' => ($sectioninfos->type) ? $sectioninfos->type : '',
            );
        } else {
            $results = array(
                'id' => '',
                'batch_id' => '',
                'section_id' => '',
                'adviser_id' => '',
                'level_id' => '',
                'type' => '',
            );
        }
        return (object) $results;
    }
}
