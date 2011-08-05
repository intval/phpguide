<?php

class TemplatesController extends Controller
{
        public $layout = '/';
    
	public function actionIndex()
	{
            $this->addscript('ui');
            $this->render('templatesList', array('templates' => Template::model()->findAll()));
	}
        
        public function actionShowConcreteTemplate($id)
        {
            $template = Template::model()->findByPk($id);
            if( $template === null)
            {
                throw new CHttpException(404);
            }
            
            $this->render('templatesFrameset', array('template' => $template));
            
        }
        
        public function actionTopframe($id)
        {
            $template = Template::model()->findByPk($id);
            
            if( $template === null)
            {
                throw new CHttpException(404);
            }
            
            $template->views++;
            $template->save();
            
            $this->render('topframe', 
                    array('nextid' => $template->getNextId(), 'previd' => $template->getPrevId(),
                        'name' => $template->name, 'filename' => $template->filename)
             );
            
        }


}