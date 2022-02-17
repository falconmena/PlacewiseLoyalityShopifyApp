# PlacewiseShopify

## Installation

Merchant install link

<img src="https://community.shopify.com/c/image/serverpage/image-id/24235i649E4B7D4DB3296A/image-size/large?v=v2&px=999" />

## Theme files:

customers/register.liquid

```shell

{%- form 'create_customer', novalidate: 'novalidate' -%}
    {%- if form.errors -%}
      <h2 class="form__message" tabindex="-1" autofocus>
        <svg aria-hidden="true" focusable="false" role="presentation">
          <use href="#icon-error" />
        </svg>
        {{ 'templates.contact.form.error_heading' | t }}
      </h2>
      <ul> 
        {%- for field in form.errors -%}
          <li>
            {%- if field == 'form' -%}
              {{ form.errors.messages[field] }}
            {%- else -%}
              <a href="#RegisterForm-{{ field }}">
                {{ form.errors.translated_fields[field] | capitalize }}
                {{ form.errors.messages[field] }}
              </a>
            {%- endif -%}
          </li>
        {%- endfor -%}
      </ul>
    {%- endif -%}
    <div class="field">      
      <input
        type="text"
        name="customer[first_name]"
        id="RegisterForm-FirstName"
        {% if form.first_name %}value="{{ form.first_name }}"{% endif %}
        autocomplete="given-name"
        placeholder="{{ 'customer.register.first_name' | t }}"
      >
      <label for="RegisterForm-FirstName">
        {{ 'customer.register.first_name' | t }}
      </label>
    </div>
    <div class="field">
      <input
        type="text"
        name="customer[last_name]"
        id="RegisterForm-LastName"
        {% if form.last_name %}value="{{ form.last_name }}"{% endif %}
        autocomplete="family-name"
        placeholder="{{ 'customer.register.last_name' | t }}"
      >
      <label for="RegisterForm-LastName">
        {{ 'customer.register.last_name' | t }}
      </label>
    </div>
    
    <div class="want-loyalty-option">
      <label for="techs_phone_number">MobileNummer </label>
      <input type="tel" id="techs_phone_number">
      <p  id="error_phone_loyalty"></p>
      <input type="hidden" id="techs_hidden_tags" name="customer[tags]" value="">
   </div>
    
   <div class="want-loyalty-option">
     <label >Kjønn </label>
     <div class="form-check form-check-inline">
       <input class="form-check-input" type="radio" name="gender" id="loyalty_radio_gender_man"  value="man">
       <label class="form-check-label" for="loyalty_radio_gender_man">Mann </label>
       <input class="form-check-input" type="radio" name="gender" id="loyalty_radio_gender_women"  value="women">
       <label class="form-check-label" for="loyalty_radio_gender_women">Kvinner </label>
     </div>
   </div> 
    
   <div class="want-loyalty-option">
     <label for="techs-birthday-layolty">Bursdag </label>
     <input class="form-control" type="date" name="birthday" id="techs-birthday-layolty">
   </div> 
   <div class="want-loyalty-option">
     <label for="techs-birthday-layolty">Vil du motta informasjon og eksklusive fordeler på SMS?* </label>
     <div class="form-check form-check-inline">
       <input class="form-check-input" type="radio" name="loyalty_radio_sms" id="loyalty_radio_yes_sms" value="true">
       <label class="form-check-label" for="loyalty_radio_yes_sms">Ja takk</label>
       <input class="form-check-input" type="radio" name="loyalty_radio_sms" id="loyalty_radio_no_sms" checked="" value="false">
       <label class="form-check-label" for="loyalty_radio_no_sms">Nei Takk</label>
     </div>
    </div>
    <div class="want-loyalty-option">
      <label for="techs-birthday-layolty">Vil du motta informasjon og eksklusive fordeler på e-post?*</label>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="loyalty_radio_email" id="loyalty_radio_yes_email" value="true">
        <label class="form-check-label" for="loyalty_radio_yes_email">Ja takk</label>
        <input class="form-check-input" type="radio" name="loyalty_radio_email" id="loyalty_radio_no_email" checked="" value="false">
        <label class="form-check-label" for="loyalty_radio_no_email">Nei Takk</label>
      </div>
    </div> 
    <div class="want-loyalty-option">
      <label for="techs-birthday-layolty">Vil du motta personlige tilpasset informasjon og fordeler?*</label>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="loyalty_radio_offers" id="loyalty_radio_yes_offers" value="true">
        <label class="form-check-label" for="loyalty_radio_yes_offers">Ja takk</label>
        <input class="form-check-input" type="radio" name="loyalty_radio_offers" id="loyalty_radio_no_offers" checked="" value="false">
        <label class="form-check-label" for="loyalty_radio_no_offers">Nei Takk</label>
      </div>
    </div>
    <div class="want-loyalty-option">
      <label for="techs-birthday-layolty">Godtar du at vi lagrer informasjonskapsler på enheten din?*</label>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="loyalty_radio_device" id="loyalty_radio_yes_device" value="true">
        <label class="form-check-label" for="loyalty_radio_yes_device">Ja takk</label>
        <input class="form-check-input" type="radio" name="loyalty_radio_device" id="loyalty_radio_no_device" checked="" value="false">
        <label class="form-check-label" for="loyalty_radio_no_device">Nei Takk</label>
      </div>
    </div>
    
    
    
    
    
    <div class="field">      
      <input
        type="email"
        name="customer[email]"
        class="RegisterForm-email"
        {% if form.email %} value="{{ form.email }}"{% endif %}
        spellcheck="false"
        autocapitalize="off"
        autocomplete="email"
        aria-required="true"
        {% if form.errors contains 'email' %}
          aria-invalid="true"
          aria-describedby="RegisterForm-email-error"
        {% endif %}
        placeholder="{{ 'customer.register.email' | t }}"
      >
      <label for="RegisterForm-email">
        {{ 'customer.register.email' | t }}
      </label>
    </div>
    {%- if form.errors contains 'email' -%}
      <span id="RegisterForm-email-error" class="form__message">
        <svg aria-hidden="true" focusable="false" role="presentation">
          <use href="#icon-error" />
        </svg>
        {{ form.errors.translated_fields['email'] | capitalize }} {{ form.errors.messages['email'] }}.
      </span>
    {%- endif -%}
    <div class="field">     
      <input
        type="password"
        name="customer[password]"
        class="RegisterForm-password"
        aria-required="true"
        {% if form.errors contains 'password' %}
          aria-invalid="true"
          aria-describedby="RegisterForm-password-error"
        {% endif %}
        placeholder="{{ 'customer.register.password' | t }}"
      >
      <label for="RegisterForm-password">
        {{ 'customer.register.password' | t }}
      </label>
    </div>
    
    <div class="field">    
    
      <input
          type="password"
          id="re-passwsord"
          aria-required="true"
          placeholder="re-password"
        >
      <label for="re-passwsord">
        Re - Passord
      </label>
    </div> 
    
    {%- if form.errors contains 'password' -%}
      <span id="RegisterForm-password-error" class="form__message">
        <svg aria-hidden="true" focusable="false" role="presentation">
          <use href="#icon-error" />
        </svg>
        {{ form.errors.translated_fields['password'] | capitalize }} {{ form.errors.messages['password'] }}.
      </span>
    {%- endif -%}
    <button class="techs_submit_value"> 
      {{ 'customer.register.submit' | t }}
    </button>
    <p class="text-center" id="error_msg"></p>

  {%- endform -%}







```

Create/Edit Loyalty Profile:

1- in shopify admin -> themes -> in the right side click on Action -> edit code -> in template (add new template) -> type page -> alternate("placewise_loyalty_profile")

2- in shopify admin -> themes -> online store -> pages -> create page(with template -> Template suffix = "placewise_loyalty_profile")

3- in shopify admin -> themes -> in the right side click on Action -> edit code -> in template -> Find the file named "page.placewise_loyalty_profile" -> then add below code in the file:

```shell

<div class='row' style="margin: auto;display: flex;">
	<div style="display:none;margin: auto;" class="loyalty_section col-md-8">
      	<h2>Opprett lojalitetsmedlem</h2>
      	<div class="form-group">
            <label for="input-fname">Fornavn </label>
            <input style="width: 100%;" required type="text" class="form-control" id="input-fname"  placeholder="Skriv inn fornavn">
        </div>
        <div class="form-group">
          <label for="input-lname">Etternavn </label>
          <input style="width: 100%;" required type="text" class="form-control" id="input-lname"  placeholder="Skriv inn etternavn">
        </div>
        <div class="form-group">
          <div class="form-check form-check-inline">
            <label class="form-check-label" for="static_sms_marketing">Kjønn</label>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="gender" value="man" id="gender_man">
              <label class="form-check-label" for="gender_man">Mann</label>
              <input class="form-check-input" type="radio" name="gender" value="woman" id="gender_women">
              <label class="form-check-label" for="gender_women">Kvinner</label>
            </div>
          </div>
        </div>
        <div class="form-group" id="phone_loyalty_sysytem">
          <label for="input-lname">MobileNummer</label>
          <input style="width: 100%;" required type="text" class="form-control" id="input-phone">
          <p  id="error_phone_loyalty"></p>
        </div>
        <div class="form-group">
          <label for="input-birthday">Bursdag </label>
          <input class="form-control" type="date" name="birthday" id="input-birthday">
        </div>
        <div class="form-group">
          <label for="input-password">Passord </label>
          <input style="width: 100%;" required type="password" class="form-control" id="input-password">
        </div>
        <div class="form-group">
          <label for="input-cpassword">bekreft passord </label>
          <input style="width: 100%;" required type="password" class="form-control" id="input-cpassword">
        </div>
        <div class="form-group">
                <label for="input-sms">Vil du motta informasjon og eksklusive fordeler på SMS?*   </label>
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
                    <label class="form-check-label" for="input-offers-yes">Ja takk</label>
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
      	<h2>LOYALTIMEDLEM</h2>
        <p>	
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
            <input style="width: 100%;" type="text" class="form-control" id="input-fname"  placeholder="Skriv inn fornavn">
          </div>
          <div class="form-group">
            <label for="input-lname">Etternavn</label>
            <input style="width: 100%;" type="text" class="form-control" id="input-lname"  placeholder="Skriv inn etternavn">
          </div>
          <div class="form-group">
            <div class="form-check form-check-inline">
              <label class="form-check-label" for="static_sms_marketing">Kjønn</label>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" value="man" id="gender_man">
                <label class="form-check-label" for="gender_man">Mann</label>
                <input class="form-check-input" type="radio" name="gender" value="woman" id="gender_women">
                <label class="form-check-label" for="gender_women">Kvinner</label>
              </div>
            </div>
          </div>
          <div class="form-group">
                <label for="input-birthday">Bursdag</label>
                <input class="form-control" type="date" name="birthday" id="input-birthday">
          </div>
          <div class="form-group">
                <label for="input-sms">Vil du motta informasjon og eksklusive fordeler på SMS?* </label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="input-sms" id="input-sms-yes" value="true">
                    <label class="form-check-label" for="input-sms-yes">Ja takk</label>
                    <input class="form-check-input" type="radio" name="input-sms" id="input-sms-no" checked="" value="false">
                    <label class="form-check-label" for="input-sms-no">Nei Takk</label>
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
                    <label class="form-check-label" for="input-offers-yes">Ja takk</label>
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






