<?php	namespace Awkwordstudio\Laramodal;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Collection;

class Modal
{
	
	/**
     * The view instance.
     *
     * @var \View
   */
	protected $view;
	
	/**
     * The redirect instance.
     *
     * @var \Redirect
   */
	protected $redirect;
	
	/**
     * The array of Bootstrap modal options
     *
     * @var \Illuminate\Support\Collection
   */
	protected $options;
	
	 /**
     * Create a new Modal instance.
     * @return void
     */   
	public function __construct()
	{
		$this->options = new Collection;
		$this->setOption('id' , 'laramodal_'.md5(time()) );
		$this->setOption('animation' , true );
		$this->setOption('size' , '' ); // - (for noraml), lg or sm
		$this->setOption('title' , '' );
		$this->setOption('dismiss' , true );
	}
	
	/**
     * Make a view instance for the modal.
     *
     * @param  string  $view
     * @param  array  $data
     * @param  array  $mergeData
     * @return $this
    */
	public function make($view, $data = array(), $mergeData = array())
	{
		$this->view = $this->render( $view, $data , $mergeData);
		
		return $this;
	}	
	
	/**
	* Prepare the response
	* @return Response
	*/
	public function response()
	{
		if($this->view){
			$response = [
					'modal'=>$this->view->render() , 
					'id'=>$this->getOption('id') ,
					'body'=>'',
			];
		}else{
			
			$response = ['redirect'=>$this->redirect->getTargetUrl()];
		}
		
		return \Response::json($response);
	}
	
	/**
     * Make the redirect instance for the modal.
     *
     * @param  string  $url
     * @return $this
     */
	public function redirect( $url )
	{
		$this->redirect = \Redirect::to( $url);
		
		return $this;
	}
	
	/**
     * Add a piece of data to the view or redirect.
     *
     * @param  string|array  $key
     * @param  mixed   $value
     * @return $this
     */
	public function with($key, $value = null)
   {

		  if($this->view){
			  
			    $this->view = $this->view->with($key, $value);
			    
		  }else{
			  
			   $this->redirect = $this->redirect->with($key, $value);
		  }
		  
        return $this;

    }

    /**
     * Add a view instance to the view data.
     *
     * @param  string  $key
     * @param  string  $view
     * @param  array   $data
     * @return $this
     */
    public function nest($key, $view, array $data = array())
    {
		 if($this->view)
			$this->view = $this->view->nest($key, $view , $data);
			
       return $this;
    }

    /**
     * Add validation errors to the view.
     *
     * @param  \Illuminate\Support\Contracts\MessageProviderInterface|array  $provider
     * @return $this
     */
    public function withErrors($provider)
    {
        if($this->view){
			  
			    $this->view = $this->view->withErrors( $provider );
		  }else{
			  
			   $this->redirect = $this->redirect->withErrors( $provider );
		  }
      
        return $this;
    }

   /**
	 * Flash an array of input to the session.
	 *
	 * @param  array  $input
	 * @return $this
	 */
	public function withInput(array $input = null)
	{
		$input = $input ?: \Request::input();

		\Session::flashInput(array_filter($input, function ($value)
		{
			return ! $value instanceof UploadedFile;
		}));

		return $this;
	}
	 
	 /**
     * Make the View instance of the Modal.
     *
     * @param  \View  $view
     * @param  array  $data
     * @param  array  $mergeData
     * @return \View
     */
	protected function render($view, $data = array(), $mergeData = array() )
	{
		$data['laramodal'] = $this;
		
		return \View::make( $view, $data , $mergeData );
	}
	
	 /**
     * Get an option for Bootstrap Modal.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
	public function getOption($key , $default = null){
		
		return $this->options->get($key , $default);
		
	}
	
	 /**
     * Set an option for Bootstrap Modal.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return $this
   */
	public function setOption($key , $value )
	{
		$this->options->put($key , $value);
		
		return $this;
	}
	
	 /**
     * Get the string contents of the Modal response.
     *
     * @return string
     */
	public function __toString()
	{
		$this->response()->send();
		
		return '';
	}
}
?>
