<?php

namespace App\Controller;

use Deozza\ResponseMakerBundle\Service\ResponseMaker;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Yaml\Yaml;


/**
 * @Route("api/")
 */
class UpdateConfigController extends AbstractController
{

    public function __construct(string $pathToIntermediateProject, ResponseMaker $responseMaker)
    {
        $this->pathToIntermediateProject = $pathToIntermediateProject;
        $this->response = $responseMaker;
    }

    /**
     *@Route("doc/enumerations",
     * name = "patch_enumeration",
     * methods = {"PATCH"})
     */
    public function patchEnumerationAction(Request $request)
    {
        $filename = __DIR__."/../../var/Philarmony/enumeration.yaml.tmp";
        file_put_contents($filename,Yaml::dump(json_decode($request->getContent(), true)));

        rename($filename,__DIR__."/../../../".$this->pathToIntermediateProject.'/enumeration.yaml.tmp');
        rename(__DIR__."/../../../".$this->pathToIntermediateProject.'/enumeration.yaml', __DIR__."/../../../".$this->pathToIntermediateProject.'/enumeration.yaml.current');
        rename(__DIR__."/../../../".$this->pathToIntermediateProject.'/enumeration.yaml.tmp', __DIR__."/../../../".$this->pathToIntermediateProject.'/enumeration.yaml');

        $validSchema = new Process("php ".__DIR__."/../../../".$this->pathToIntermediateProject."../../bin/console p:s:v");
        $validSchema->run();

        if(!$validSchema->isSuccessful())
        {
            unlink(__DIR__."/../../../".$this->pathToIntermediateProject.'/enumeration.yaml');
            rename(__DIR__."/../../../".$this->pathToIntermediateProject.'/enumeration.yaml.current', __DIR__."/../../../".$this->pathToIntermediateProject.'/enumeration.yaml');

            return $this->response->badRequest("Data schema is invalid \n\n".$validSchema->getOutput());
        }

        $generateForm = new Process("php ".__DIR__."/../../../".$this->pathToIntermediateProject."../../bin/console p:m:m");
        $generateForm->run();

        if(!$generateForm->isSuccessful())
        {
            unlink(__DIR__."/../../../".$this->pathToIntermediateProject.'/enumeration.yaml');
            rename(__DIR__."/../../../".$this->pathToIntermediateProject.'/enumeration.yaml.current', __DIR__."/../../../".$this->pathToIntermediateProject.'/enumeration.yaml');
            return $this->response->badRequest("Forms cannot be created \n\n".$generateForm->getErrorOutput());
        }
        unlink(__DIR__."/../../../".$this->pathToIntermediateProject.'/enumeration.yaml.current');

        $commitProcess = new Process('cd '.__DIR__."/../../../".$this->pathToIntermediateProject."../../ ; git add . ; git commit -m 'update enumeration' ; git push;");
        $commitProcess->setTimeout(300);
        $commitProcess->run();
        if(!$commitProcess->isSuccessful())
        {
            unlink(__DIR__."/../../../".$this->pathToIntermediateProject.'/enumeration.yaml');
            rename(__DIR__."/../../../".$this->pathToIntermediateProject.'/enumeration.yaml.current', __DIR__."/../../../".$this->pathToIntermediateProject.'/enumeration.yaml');
            return $this->response->badRequest("Commit failed \n\n".$generateForm->getErrorOutput());
        }


        return $this->response->empty();
    }
}