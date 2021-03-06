<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Template extends Model
{
    protected $table = 'templates';
    public $timestamps = true;

    public function user() {
        return $this->belongsTo('User');
    }

    public function field() {
        return $this->hasMany('Field');
    }

    public function createNewTemplate($templateName) {

        $preparedName = $this->prepare($templateName);

        $template = new Template();
        $template->name = $preparedName;
        $template->work = false;
        $template->user_id = Auth::user()->id;

        $template->save();

        return $template->id;
    }

    public function prepare($data) {
        return $data;
    }

    public static function templateInfoFormId($templateId)
    {
        $result = Template::where('id', '=', $templateId)->firstOrFail();

        return $result;
    }

    public static function startTemplateToWork($templateID) {

        $result = Template::where('id', $templateID)
            ->update(['work' => 1]);

        return $result;
    }

    public static function stopTemplateFromWork($templateID) {
        $result = Template::where('id', $templateID)
            ->update(['work' => 0]);

        return $result;
    }

}
