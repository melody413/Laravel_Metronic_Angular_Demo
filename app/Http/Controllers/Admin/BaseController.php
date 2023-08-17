<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use GrahamCampbell\Flysystem\Facades\Flysystem;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

abstract class BaseController extends Controller
{
    public function __construct()
    {
        //\App::setLocale('ar');

        if(method_exists($this,'init'))
            $this->init();
    }

    public function getAjax($query, $param)
    {

    }


    protected function moveFile($file , $path)
    {
        $directory = public_path('uploads/') . $path;

        if (!Flysystem::connection('local')->createDir($directory))
            throw new \Exception(sprintf('we can not create directory %s please give the root folder permission to write in it', $directory));

        $fullName = null;

        $fileName  =  md5(rand(0,999).time()) ;
        if ($file->isValid())
        {
            $fullName = $fileName . '.' . $file->guessExtension();
            $file->move($directory , $fullName);
        }

        return $fullName;
    }

    protected function getTemplatePath($template)
    {
        return sprintf('admin.%s.%s', $this->getTemplateFolder(), $template);
    }

    abstract protected function getTemplateFolder();
}
