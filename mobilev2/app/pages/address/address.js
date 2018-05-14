import {IonicApp, Page, Alert, NavController, NavParams, Storage, LocalStorage} from 'ionic-angular';
import {Services} from '../../providers/services/services';
import {SQLite} from '../../providers/sqlite/sqlite';
import {AddressesPage} from '../addresses/addresses';
import { Component } from 'angular2/core';
import { FORM_DIRECTIVES, FormBuilder, ControlGroup, Validators, AbstractControl } from 'angular2/common';

/*
  Generated class for the AddressPage page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Page({
  templateUrl: 'build/pages/address/address.html',
  directives: [FORM_DIRECTIVES]
})
export class AddressPage {
  static get parameters() {
    return [[IonicApp], [Services], [NavController], [NavParams], [FormBuilder], [SQLite]];
  }

  constructor(app, service, nav, params, fb, sqlite) {

    this.address_id = params.get('address');

    this.loading = app.getComponent('loading');  
    this.loading.show();

    this.nav = nav;

    this.service = service;

    this.sqlite = sqlite;

    this.local = new Storage(LocalStorage);

    this.heading = 'Add Address';
    var current_address = [];
    
    this.authForm = fb.group({
        'label': ['', Validators.compose([Validators.required, Validators.maxLength(20)])],
        'fname': ['', Validators.compose([Validators.required, Validators.maxLength(20)])],
        'lname': ['', Validators.compose([Validators.required, Validators.maxLength(20)])],
        'address1': ['', Validators.compose([Validators.required])],
        'address2': ['', Validators.compose()],
        'area': ['', Validators.compose()],
        'city': ['', Validators.compose([Validators.required, Validators.maxLength(20)])],
        'state': ['', Validators.compose([Validators.required, Validators.maxLength(20)])],
        'pincode': ['', Validators.compose([Validators.required, Validators.maxLength(6)])]
    });

    this.label = this.authForm.controls['label'];
    this.fname = this.authForm.controls['fname'];
    this.lname = this.authForm.controls['lname'];
    this.address1 = this.authForm.controls['address1'];
    this.address2 = this.authForm.controls['address2'];     
    this.area = this.authForm.controls['area'];
    this.city = this.authForm.controls['city'];
    this.state = this.authForm.controls['state'];
    this.pincode = this.authForm.controls['pincode'];

    service.loadAreas().subscribe(data => {
        console.log(data.status);
        this.loading.hide();
        if(data.status == 'true') {
            this.contents = data.data;
        }
    });

    if(this.address_id != 0) {
        sqlite.getDeliveryAddressByID(this.address_id).then((result) => {
            current_address = result.res.rows.item(0);
            this.address_label = current_address.strLabel;
            this.address_fname = current_address.strFirstName;
            this.address_lname = current_address.strLastName;
            this.address_line1 = current_address.strAddressLine1;
            this.address_line2 = current_address.strAddressLine2;
            this.area = current_address.idArea;
            this.area_name = current_address.strArea;
            this.area_city = current_address.strCity;
            this.area_state = current_address.strState;
            this.area_pincode = current_address.intPincode;

            this.heading = 'Edit '+this.address_label;
        });
    }
    
  }

  itemSelected() {
    this.contents.forEach(function(area) {
      if(area.id == this.area) {
        this.area_city = area.city;
        this.area_state = area.state;
        this.area_pincode = area.pincode;
        this.area_name = area.name;
      }
    }, this);
  }

  onSubmit(value) {
        
      this.loading.show();

      value.area = this.area;
      value.area_name = this.area_name;
      
      var user_id = 0;
      this.local.get('UserId').then((result) => {
          if(result) {
              user_id = result;
          }
    
          this.service.addAddress(user_id, this.area, value, this.address_id).subscribe(data => {
              this.loading.hide();
              if(data.status == 'false') {
                  var alert = Alert.create({
                      title: 'ERROR!',
                      message: data.msg,
                      buttons: ['Ok']
                  });
                  this.nav.present(alert);
              } else {
                  this.nav.pop();
                  this.sqlite.addDeliveryAddress(value, this.address_id);
              }
          });
      });
  }
}
