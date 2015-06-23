<?php
Pluf::loadFunction ( 'Pluf_HTTP_URL_urlForView' );
Pluf::loadFunction ( 'Bank_Shortcuts_receiptFactory' );

/**
 * فرم به روز رسانی آپارتمان
 *
 * این فرم تمام داده‌های یک آپارتمان را دریافت کرده و آپارتمان معادل را
 * به روز می‌کند. در صورتی که خطایی در این سطح رخ دهد به صورت استثنا صادر
 * خواهد شد
 *
 * @author maso <mostafa.barmshory@dpq.co.ir>
 *        
 */
class Bank_Form_Mellat extends Pluf_Form {
	var $profile_data = null;
	public function initFields($extra = array()) {
		if (array_key_exists ( 'user_profile', $extra )) {
			$this->profile_data = $extra ['user_profile'];
		}
		$this->profile_data = Advisor_Shortcuts_UserProfileFactory ( $this->profile_data );
		
		$this->fields ['local'] = new Pluf_Form_Field_Varchar ( array (
				'required' => false,
				'label' => __ ( 'local' ),
				'initial' => $this->profile_data->local 
		) );
		$this->fields ['state'] = new Pluf_Form_Field_Varchar ( array (
				'required' => false,
				'label' => __ ( 'state' ),
				'initial' => $this->profile_data->state 
		) );
		$this->fields ['country'] = new Pluf_Form_Field_Varchar ( array (
				'required' => false,
				'label' => __ ( 'country' ),
				'initial' => $this->profile_data->country 
		) );
		$this->fields ['phone_number'] = new Pluf_Form_Field_Varchar ( array (
				'required' => false,
				'label' => __ ( 'phone number' ),
				'initial' => $this->profile_data->phone_number 
		) );
		$this->fields ['mobile_number'] = new Pluf_Form_Field_Varchar ( array (
				'required' => false,
				'label' => __ ( 'mobile number' ),
				'initial' => $this->profile_data->mobile_number 
		) );
	}
	
	// XXX: maso 1391: ارسال رایانامه برای آگاهی کاربران
	private function send_validation_mail($new_email, $secondary_mail = false) {
		// $type = "primary";
		// $cr = new Pluf_Crypt(md5(Pluf::f('secret_key')));
		// $encrypted = trim($cr->encrypt($new_email.':'.$this->user->id.':'.time().':'.$type), '~');
		// $key = substr(md5(Pluf::f('secret_key').$encrypted), 0, 2).$encrypted;
		// $url = Pluf::f('url_base').Pluf_HTTP_URL_urlForView('Peechak_Views_User::changeEmailDo', array($key), array(), false);
		// $urlik = Pluf::f('url_base').Pluf_HTTP_URL_urlForView('Peechak_Views_User::changeEmailInputKey', array(), array(), false);
		// $context = new Pluf_Template_Context(
		// array('key' => Pluf_Template::markSafe($key),
		// 'url' => Pluf_Template::markSafe($url),
		// 'urlik' => Pluf_Template::markSafe($urlik),
		// 'email' => $new_email,
		// 'user'=> $this->user,
		// )
		// );
		// $tmpl = new Pluf_Template('peechak/mail/user/changeemail-email.txt');
		// $text_email = $tmpl->render($context);
		// $email = new Pluf_Mail(Pluf::f('from_email'), $new_email,
		// __('Confirm your new email address.'));
		// $email->addTextMessage($text_email);
		// $email->sendMail();
		// $this->user->setMessage(sprintf(__('A validation email has been sent to "%s" to validate the email address change.'), Pluf_esc($new_email)));
	}
	
	/**
	 * مدل داده‌ای را ذخیره می‌کند
	 *
	 * مدل داده‌ای را بر اساس تغییرات تعیین شده توسط کاربر به روز می‌کند. در صورتی
	 * که پارامتر ورودی با نا درستی مقدار دهی شود تغییراد ذخیره نمی شود در غیر این
	 * صورت داده‌ها در پایگاه داده ذخیره می‌شود.
	 *
	 * @param $commit داده‌ها
	 *        	ذخیره شود یا نه
	 * @return مدل داده‌ای تغییر یافته
	 */
	function save($commit = true) {
		if (! $this->isValid ()) {
			throw new Pluf_Exception ( __ ( 'Cannot save the apartment from an invalid form.' ) );
		}
		// Set attributes
		$this->profile_data->setFromFormData ( $this->cleaned_data );
		if ($commit) {
			if (! $this->profile_data->create ()) {
				throw new Pluf_Exception ( __ ( 'Fail to update the apartment.' ) );
			}
		}
		return $this->profile_data;
	}
	
	/**
	 * موجودیت را به روز می‌کند.
	 *
	 * @param string $commit        	
	 * @throws Pluf_Exception
	 * @return Ambigous <unknown, Advisor_Models_UserProfile>
	 */
	function update($commit = true) {
		if (! $this->isValid ()) {
			throw new Pluf_Exception ( __ ( 'Cannot save the apartment from an invalid form.' ) );
		}
		// Set attributes
		$this->profile_data->setFromFormData ( $this->cleaned_data );
		if ($commit) {
			if (! $this->profile_data->update ()) {
				throw new Pluf_Exception ( __ ( 'Fail to update the apartment.' ) );
			}
		}
		return $this->profile_data;
	}
}
