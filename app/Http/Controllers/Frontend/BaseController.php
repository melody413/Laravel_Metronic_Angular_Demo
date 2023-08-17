<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

abstract class BaseController extends Controller
{
    public function __construct(Request $request)
    {

        App::setLocale($request->get('lang'));

        if(method_exists($this,'init'))
            $this->init($request);
    }

    protected function moveFile($file , $path)
    {
        $directory = storage_path('uploads/') . $path;

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
        return sprintf('frontend.%s.%s', $this->getTemplateFolder(), $template);
    }

    public static function getSubDomain()
    {
        return explode('.',\request()->getHost())[0];
    }

    abstract protected function getTemplateFolder();
}
