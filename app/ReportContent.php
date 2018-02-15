<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportContent extends Model
{
    
    public $table = 'report_content';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $primaryKey = 'comment_id';
    protected $fillable = [
        'id', 'report_content', 'created_at', 'updated_at', 'comment_id',
        'type'
    ];
    
   public static function addReportContent($data){
       
       $report = new ReportContent();
       $report->fill($data);
       
       if($report->save()){
           return true;
       }
       return false;
   }
}
