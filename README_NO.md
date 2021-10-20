
# PlacewiseShopify

## Installation

Merchant install link

<img src="https://community.shopify.com/c/image/serverpage/image-id/24235i649E4B7D4DB3296A/image-size/large?v=v2&px=999" />

plasewise link
```shell
https://shopify.placewise-services.com/install.php
```
## Theme files:

customers/register.liquid

```shell
  <div class="form-group" style="text-align: center;">
                <div class="form-check form-check-inline">
                    <label class="form-check-label" for="static_sms_marketing">Want to be loyalty member ?</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="loyalty_radio" value="yes" id="loyalty_radio_yes">
                        <label class="form-check-label" for="loyalty_radio_yes">Yes</label>
                        <input class="form-check-input" type="radio" name="loyalty_radio" value="no" id="loyalty_radio_no" checked="">
                        <label class="form-check-label" for="loyalty_radio_no">No</label>
                    </div>
                </div>
            </div>
            <div class="want-loyalty-option" style="display:none;">
                <label for="{{ formId }}-FirstName">{{ 'customer.register.first_name' | t }}</label>
                <input type="text" name="customer[first_name]" id="{{ formId }}-FirstName" {% if form.first_name %}value="{{ form.first_name }}"{% endif %} autocomplete="given-name">
            </div>
            <div class="want-loyalty-option" style="display:none;">
                <label for="{{ formId }}-LastName">{{ 'customer.register.last_name' | t }}</label>
                <input type="text" name="customer[last_name]" id="{{ formId }}-LastName" {% if form.last_name %}value="{{ form.last_name }}"{% endif %} autocomplete="family-name">
            </div>
            <div class="want-loyalty-option" style="display:none;">
                <label for="techs_phone_number">Phone</label>
                <input type="tel" id="techs_phone_number">
              	<p  id="error_phone_loyalty"></p>
                <input type="hidden" id="techs_hidden_tags" name="customer[tags]" value="">
            </div>
            
          
<!--           	<div class="want-loyalty-option" style="display:none;">
                <label for="techs-gender-layolty">Gender</label>
                <select name="gender" id="techs-gender-layolty">
                    <option value="man">Man</option>
                    <option value="woman">Woman</option>
                </select>
            </div> -->
          
          	<div class="want-loyalty-option" style="display:none;">
                <label >Gender</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="loyalty_radio_gender_man"  value="man">
                    <label class="form-check-label" for="loyalty_radio_gender_man">Man</label>
                    <input class="form-check-input" type="radio" name="gender" id="loyalty_radio_gender_women"  value="women">
                    <label class="form-check-label" for="loyalty_radio_gender_women">Woman</label>
                </div>
            </div>
            <div class="want-loyalty-option" style="display:none;">
                <label for="techs-birthday-layolty">Birthday</label>
                <input class="form-control" type="date" name="birthday" id="techs-birthday-layolty">
            </div>
            <div class="want-loyalty-option" style="display:none;">
                <label for="techs-birthday-layolty">Do you want to receive exclusive offers, information and discounts by SMS? </label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="loyalty_radio_sms" id="loyalty_radio_yes_sms" value="true">
                    <label class="form-check-label" for="loyalty_radio_yes_sms">Yes</label>
                    <input class="form-check-input" type="radio" name="loyalty_radio_sms" id="loyalty_radio_no_sms" checked="" value="false">
                    <label class="form-check-label" for="loyalty_radio_no_sms">No</label>
                </div>
            </div>
            <div class="want-loyalty-option" style="display:none;">
                <label for="techs-birthday-layolty">Do you want to receive exclusive offers, information and discounts by e-mail?</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="loyalty_radio_email" id="loyalty_radio_yes_email" value="true">
                    <label class="form-check-label" for="loyalty_radio_yes_email">Yes</label>
                    <input class="form-check-input" type="radio" name="loyalty_radio_email" id="loyalty_radio_no_email" checked="" value="false">
                    <label class="form-check-label" for="loyalty_radio_no_email">No</label>
                </div>
            </div>
            <div class="want-loyalty-option" style="display:none;">
                <label for="techs-birthday-layolty">Do you want to receive customized offers? </label>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="loyalty_radio_offers" id="loyalty_radio_yes_offers" value="true">
                  <label class="form-check-label" for="loyalty_radio_yes_offers">Yes</label>
                  <input class="form-check-input" type="radio" name="loyalty_radio_offers" id="loyalty_radio_no_offers" checked="" value="false">
                  <label class="form-check-label" for="loyalty_radio_no_offers">No</label>
                </div>
            </div>
            <div class="want-loyalty-option" style="display:none;">
                <label for="techs-birthday-layolty">Do you agree that we store cookies on your device?</label>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="loyalty_radio_device" id="loyalty_radio_yes_device" value="true">
                  <label class="form-check-label" for="loyalty_radio_yes_device">Yes</label>
                  <input class="form-check-input" type="radio" name="loyalty_radio_device" id="loyalty_radio_no_device" checked="" value="false">
                  <label class="form-check-label" for="loyalty_radio_no_device">No</label>
                </div>
            </div>	
            <p class="text-center">
              <input type="submit" id="techs_submit_value" value="{{ 'customer.register.submit' | t }}" class="btn">
            </p>
            <p class="text-center" id="error_msg"></p>
```

Create/Edit Loyalty Profile:

1- in shopify admin -> themes -> in the right side click on Action -> edit code -> in template (add new template) -> type page -> alternate("placewise_loyalty_profile")

2- in shopify admin -> themes -> online store -> pages -> create page(with template -> Template suffix = "placewise_loyalty_profile")

3- in shopify admin -> themes -> in the right side click on Action -> edit code -> in template -> Find the file named "page.placewise_loyalty_profile" -> then add below code in the file:

```shell

        <div class='row' style="margin: auto;display: flex;">
<div style="display:none;margin: auto;" class="loyalty_section col-md-8">
      	<h2>Create Loyalty Member</h2>
      	<div class="form-group">
            <label for="input-fname">First name</label>
            <input style="width: 100%;" required type="text" class="form-control" id="input-fname"  placeholder="Enter First Name">
        </div>
        <div class="form-group">
          <label for="input-lname">Last name</label>
          <input style="width: 100%;" required type="text" class="form-control" id="input-lname"  placeholder="Enter Last Name">
        </div>
        <div class="form-group">
          <div class="form-check form-check-inline">
            <label class="form-check-label" for="static_sms_marketing">Gender</label>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="gender" value="man" id="gender_man">
              <label class="form-check-label" for="gender_man">Man</label>
              <input class="form-check-input" type="radio" name="gender" value="woman" id="gender_women">
              <label class="form-check-label" for="gender_women">Woman</label>
            </div>
          </div>
        </div>
        <div class="form-group" id="phone_loyalty_sysytem">
          <label for="input-lname">Phone</label>
          <input style="width: 100%;" required type="text" class="form-control" id="input-phone">
        </div>
        <div class="form-group">
          <label for="input-birthday">Birthday</label>
          <input class="form-control" type="date" name="birthday" id="input-birthday">
        </div>
        <div class="form-group">
          <label for="input-password">Password</label>
          <input style="width: 100%;" required type="password" class="form-control" id="input-password">
        </div>
        <div class="form-group">
          <label for="input-cpassword">Confirm Password</label>
          <input style="width: 100%;" required type="password" class="form-control" id="input-cpassword">
        </div>
        <div class="form-group">
                <label for="input-sms">Do you want to receive exclusive offers, information and discounts by SMS? </label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="input-sms" id="input-sms-yes" value="true">
                    <label class="form-check-label" for="input-sms-yes">Yes</label>
                    <input class="form-check-input" type="radio" name="input-sms" id="input-sms-no" checked="" value="false">
                    <label class="form-check-label" for="input-sms-no">No</label>
                </div>
          </div>
          <div class="form-group">
                <label for="input-email">Do you want to receive exclusive offers, information and discounts by e-mail?</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="input-email" id="input-email-yes" value="true">
                    <label class="form-check-label" for="input-email-yes">Yes</label>
                    <input class="form-check-input" type="radio" name="input-email" id="input-email-no" checked="" value="false">
                    <label class="form-check-label" for="input-email-no">No</label>
                </div>
          </div>
          <div class="form-group">
                <label for="input-offers">Do you want to receive customized offers?</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="input-offers" id="input-offers-yes" value="true">
                    <label class="form-check-label" for="input-email-yes">Yes</label>
                    <input class="form-check-input" type="radio" name="input-offers" id="input-offers-no" checked="" value="false">
                    <label class="form-check-label" for="input-offers-no">No</label>
                </div>
          </div>
          <div class="form-group">
                <label for="input-device">Do you agree that we store cookies on your device?</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="input-device" id="input-device-yes" value="true">
                    <label class="form-check-label" for="input-device-yes">Yes</label>
                    <input class="form-check-input" type="radio" name="input-device" id="input-device-no" checked="" value="false">
                    <label class="form-check-label" for="input-device-no">No</label>
                </div>
          </div>
          <p class="text-center" id="error_msg_add_member"></p>
          <button type="submit" id="submit_loyalty_system_add_account" class="btn btn-primary">Submit</button>
      </div>
  </div>
  <div class='row' style="margin: auto;display: flex;">	
      <div style="display:none;margin: auto;" class="loyalty_section_active col-md-8">
      	<h2>{{ "loyalty.info.title" | t }}</h2>
        <p>	
          	<span>Points :</span> 
        	<span class="loyalty_info_points"></span>
        </p>
<!--         <p>	
          	<span>Points used :</span> 
        	<span class="loyalty_info_points_used"></span>
        </p> -->
        <p>	
          	<span>Email :</span> 
        	<span class="loyalty_info_email"></span>
        </p>
        <p>	
          	<span>Phone :</span> 
        	<span class="loyalty_info_phone"></span>
        </p>
        <form id="form_loyalty_system">
          <div class="form-group">
            <label for="input-fname">First name</label>
            <input style="width: 100%;" type="text" class="form-control" id="input-fname"  placeholder="Enter First Name">
          </div>
          <div class="form-group">
            <label for="input-lname">Last name</label>
            <input style="width: 100%;" type="text" class="form-control" id="input-lname"  placeholder="Enter Last Name">
          </div>
          <div class="form-group">
            <div class="form-check form-check-inline">
              <label class="form-check-label" for="static_sms_marketing">Gender</label>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" value="man" id="gender_man">
                <label class="form-check-label" for="gender_man">Man</label>
                <input class="form-check-input" type="radio" name="gender" value="woman" id="gender_women">
                <label class="form-check-label" for="gender_women">Woman</label>
              </div>
            </div>
          </div>
          <div class="form-group">
                <label for="input-birthday">Birthday</label>
                <input class="form-control" type="date" name="birthday" id="input-birthday">
          </div>
          <div class="form-group">
                <label for="input-sms">Do you want to receive exclusive offers, information and discounts by SMS? </label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="input-sms" id="input-sms-yes" value="true">
                    <label class="form-check-label" for="input-sms-yes">Yes</label>
                    <input class="form-check-input" type="radio" name="input-sms" id="input-sms-no" checked="" value="false">
                    <label class="form-check-label" for="input-sms-no">No</label>
                </div>
          </div>
          <div class="form-group">
                <label for="input-email">Do you want to receive exclusive offers, information and discounts by e-mail?</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="input-email" id="input-email-yes" value="true">
                    <label class="form-check-label" for="input-email-yes">Yes</label>
                    <input class="form-check-input" type="radio" name="input-email" id="input-email-no" checked="" value="false">
                    <label class="form-check-label" for="input-email-no">No</label>
                </div>
          </div>
          <div class="form-group">
                <label for="input-offers">Do you want to receive customized offers?</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="input-offers" id="input-offers-yes" value="true">
                    <label class="form-check-label" for="input-email-yes">Yes</label>
                    <input class="form-check-input" type="radio" name="input-offers" id="input-offers-no" checked="" value="false">
                    <label class="form-check-label" for="input-offers-no">No</label>
                </div>
          </div>
          <div class="form-group">
                <label for="input-device">Do you agree that we store cookies on your device?</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="input-device" id="input-device-yes" value="true">
                    <label class="form-check-label" for="input-device-yes">Yes</label>
                    <input class="form-check-input" type="radio" name="input-device" id="input-device-no" checked="" value="false">
                    <label class="form-check-label" for="input-device-no">No</label>
                </div>
          </div>
          <p class="text-center" id="error_msg_edit_member"></p>
          <button type="submit" id="submit_loyalty_system_account" class="btn btn-primary">Submit</button>
        </form>  
      </div>
	</div>



```


Add Button "Create account or log in and start to earn bonus" in Cart Page:

in shopify admin -> themes -> in the right side click on Action -> edit code -> in Sections -> Find the file named "cart-template.liquid" -> then add below code in the file:

```shell

<div style="margin-top: 16px;display:none;" id="div-btn-login-cart">
              <div class="cart__buttons-container">
                <div class="cart__submit-controls">
                  <button  class="cart__submit btn btn--small-wide" id="btn-login-cart">Create account or log in and start to earn bonus</button>
                </div>
              </div>
      		</div>

```






```


Create/Edit Loyalty System in account page:

in shopify admin -> themes -> in the right side click on Action -> edit code -> in Template -> Find the file named "custom/account.liquid" -> then add below code in the file:

```shell

<div class="page-width">
  <div class="grid">
    <div class="grid__item medium-up--five-sixths medium-up--push-one-twelfth">
      <div class="section-header text-center">
        <h1>{{ page.title }}</h1>
      </div>
      <div class="rte">
        <div class='row' style="margin: auto;display: flex;">
<div style="display:none;margin: auto;" class="loyalty_section col-md-8">
      	<h2>Opprett lojalitetsmedlem</h2>
      	<div class="form-group">
            <label for="input-fname">Fornavn </label>
            <input style="width: 100%;" required type="text" class="form-control" id="input-fname"  placeholder="Enter First Name">
        </div>
        <div class="form-group">
          <label for="input-lname">Etternavn </label>
          <input style="width: 100%;" required type="text" class="form-control" id="input-lname"  placeholder="Enter Last Name">
        </div>
        <div class="form-group">
          <div class="form-check form-check-inline">
            <label class="form-check-label" for="static_sms_marketing">Kjønn </label>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="gender" value="man" id="gender_man">
              <label class="form-check-label" for="gender_man">Mann </label>
              <input class="form-check-input" type="radio" name="gender" value="woman" id="gender_women">
              <label class="form-check-label" for="gender_women">Kvinner </label>
            </div>
          </div>
        </div>
        <div class="form-group" id="phone_loyalty_sysytem">
          <label for="input-lname">MobileNummer </label>
          <input style="width: 100%;" required type="text" class="form-control" id="input-phone">
        </div>
        <div class="form-group">
          <label for="input-birthday">Bursdag </label>
          <input class="form-control" type="date" name="birthday" id="input-birthday">
        </div>
        <div class="form-group">
          <label for="input-password">Passord</label>
          <input style="width: 100%;" required type="password" class="form-control" id="input-password">
        </div>
        <div class="form-group">
          <label for="input-cpassword">bekreft passord</label>
          <input style="width: 100%;" required type="password" class="form-control" id="input-cpassword">
        </div>
        <div class="form-group">
                <label for="input-sms">Vil du motta informasjon og eksklusive fordeler på SMS?* </label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="input-sms" id="input-sms-yes" value="true">
                    <label class="form-check-label" for="input-sms-yes">Ja takk </label>
                    <input class="form-check-input" type="radio" name="input-sms" id="input-sms-no" checked="" value="false">
                    <label class="form-check-label" for="input-sms-no">Nei Takk </label>
                </div>
          </div>
          <div class="form-group">
                <label for="input-email">Vil du motta informasjon og eksklusive fordeler på e-post?* </label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="input-email" id="input-email-yes" value="true">
                    <label class="form-check-label" for="input-email-yes">Ja takk</label>
                    <input class="form-check-input" type="radio" name="input-email" id="input-email-no" checked="" value="false">
                    <label class="form-check-label" for="input-email-no">Nei Takk</label>
                </div>
          </div>
          <div class="form-group">
                <label for="input-offers">Vil du motta personlige tilpasset informasjon og fordeler?* </label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="input-offers" id="input-offers-yes" value="true">
                    <label class="form-check-label" for="input-email-yes">Ja takk</label>
                    <input class="form-check-input" type="radio" name="input-offers" id="input-offers-no" checked="" value="false">
                    <label class="form-check-label" for="input-offers-no">Nei Takk</label>
                </div>
          </div>
          <div class="form-group">
                <label for="input-device">Godtar du at vi lagrer informasjonskapsler på enheten din?*</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="input-device" id="input-device-yes" value="true">
                    <label class="form-check-label" for="input-device-yes">Ja takk</label>
                    <input class="form-check-input" type="radio" name="input-device" id="input-device-no" checked="" value="false">
                    <label class="form-check-label" for="input-device-no">Nei Takk</label>
                </div>
          </div>
          <p class="text-center" id="error_msg_add_member"></p>
          <button type="submit" id="submit_loyalty_system_add_account" class="btn btn-primary">Sende inn</button>
      </div>
  </div>
  <div class='row' style="margin: auto;display: flex;">	
      <div style="display:none;margin: auto;" class="loyalty_section_active col-md-8">
      	<h2>REDIGER LOYALTIMEDLEM</h2>
        <p class="{{ 'loyalty_placewise.placewise_profile.title' | t }}">	
          	<span>Poeng :</span> 
        	<span class="loyalty_info_points"></span>
        </p>
        <p>	
          	<span>E-post :</span> 
        	<span class="loyalty_info_email"></span>
        </p>
        <p>	
          	<span>MobileNummer :</span> 
        	<span class="loyalty_info_phone"></span>
        </p>
        <form id="form_loyalty_system">
          <div class="form-group">
            <label for="input-fname">Fornavn </label>
            <input style="width: 100%;" type="text" class="form-control" id="input-fname"  placeholder="Enter First Name">
          </div>
          <div class="form-group">
            <label for="input-lname">Etternavn </label>
            <input style="width: 100%;" type="text" class="form-control" id="input-lname"  placeholder="Enter Last Name">
          </div>
          <div class="form-group">
            <div class="form-check form-check-inline">
              <label class="form-check-label" for="static_sms_marketing">Kjønn </label>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" value="man" id="gender_man">
                <label class="form-check-label" for="gender_man">Mann</label>
                <input class="form-check-input" type="radio" name="gender" value="woman" id="gender_women">
                <label class="form-check-label" for="gender_women">Kvinner</label>
              </div>
            </div>
          </div>
          <div class="form-group">
                <label for="input-birthday">Bursdag </label>
                <input class="form-control" type="date" name="birthday" id="input-birthday">
          </div>
          <div class="form-group">
                <label for="input-sms">Vil du motta informasjon og eksklusive fordeler på SMS?* </label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="input-sms" id="input-sms-yes" value="true">
                    <label class="form-check-label" for="input-sms-yes">Ja takk </label>
                    <input class="form-check-input" type="radio" name="input-sms" id="input-sms-no" checked="" value="false">
                    <label class="form-check-label" for="input-sms-no">Nei Takk </label>
                </div>
          </div>
          <div class="form-group">
                <label for="input-email">Vil du motta informasjon og eksklusive fordeler på e-post?*</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="input-email" id="input-email-yes" value="true">
                    <label class="form-check-label" for="input-email-yes">Ja takk</label>
                    <input class="form-check-input" type="radio" name="input-email" id="input-email-no" checked="" value="false">
                    <label class="form-check-label" for="input-email-no">Nei Takk</label>
                </div>
          </div>
          <div class="form-group">
                <label for="input-offers">Vil du motta personlige tilpasset informasjon og fordeler?*</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="input-offers" id="input-offers-yes" value="true">
                    <label class="form-check-label" for="input-email-yes">Ja takk</label>
                    <input class="form-check-input" type="radio" name="input-offers" id="input-offers-no" checked="" value="false">
                    <label class="form-check-label" for="input-offers-no">Nei Takk</label>
                </div>
          </div>
          <div class="form-group">
                <label for="input-device">Godtar du at vi lagrer informasjonskapsler på enheten din?*</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="input-device" id="input-device-yes" value="true">
                    <label class="form-check-label" for="input-device-yes">Ja takk</label>
                    <input class="form-check-input" type="radio" name="input-device" id="input-device-no" checked="" value="false">
                    <label class="form-check-label" for="input-device-no">Nei Takk</label>
                </div>
          </div>
          <p class="text-center" id="error_msg_edit_member"></p>
          <button type="submit" id="submit_loyalty_system_account" class="btn btn-primary">Sende inn</button>
        </form>  
      </div>
	</div>

      </div>
    </div>
  </div>
</div>


```













```

generate discount by customer depends on actual points:

1- in shopify admin -> themes -> in the right side click on Action -> edit code -> Sections ->cart-template.liquid add ->then add below code in the file:

```shell


<div class='row table_offers_view' style="margin: auto;text-align:left;width:100%;display:none;">
                    <div class='col-6 col-md-6 table_offers_view'>
                      	<p>Offers</p>
                      	<table class="table">
                          <thead>
                            <tr>
                              <th scope="col">Code</th>
                              <th scope="col">Value</th>
                              <th scope="col">Used</th>
                            </tr>
                          </thead>
                          <tbody id='record_generate_discount'>
                            
                          </tbody>
                        </table>

                    </div>
                    <div class='col-6 col-md-6'>
                      	<h1>Generate Token</h1>
                      	<p id='msg_generate_discount'></p>
                      	<div class="form-group">
                          <div class="form-check form-check-inline">
                            <p>Actual Points (<span id="cart_actual_points"></span>)</p>
                            <label class="form-check-label" for="static_points">Points</label>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="number" name="static_points" id="input_generate_discount">
                            </div>
                          </div>
                          <div class="submit">
                            <button id='button_generate_discount'>Generate</button>
                          </div>  
                        </div>
                    </div>
  				  </div>




```






