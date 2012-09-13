<? 
class UserinfoForm extends CFormModel
{
	public $about;
	public $city;
	public $site;
	public $rememberMe=false;

	private $_identity;

	public function __construct($user){
		$this->about = $user->about;
	}
	
	public function rules()
	{
		return array(
				array('city', 'length', 'min'=>2, 'max'=>30),
				array('site', 'url'),
				array('about', 'length', 'min'=>3)
		);
	}

}
?>