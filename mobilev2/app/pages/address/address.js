import {IonicApp, Page, Alert, NavController, NavParams, Storage, LocalStorage} from 'ionic-angular';
import {Services} from '../../providers/services/services';
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
    return [[IonicApp], [Services], [NavController], [NavParams], [FormBuilder]];
  }

  constructor(app, service, nav, params, fb) {

    var address = params.get('address');

    this.loading = app.getComponent('loading');  
    this.loading.show();

    this.nav = nav;

    this.service = service;

    this.local = new Storage(LocalStorage);

    this.authForm = fb.group({
        'label': ['', Validators.compose([Validators.required, Validators.maxLength(20)])],
        'fname': ['', Validators.compose([Validators.required, Validators.maxLength(20)])],
        'lname': ['', Validators.compose([Validators.required, Validators.maxLength(20)])],
        'address_line_1': ['', Validators.compose([Validators.required])],
        'address_line_2': ['', Validators.compose()],
        'area': ['', Validators.compose()],
        'city': ['', Validators.compose([Validators.required, Validators.maxLength(20)])],
        'state': ['', Validators.compose([Validators.required, Validators.maxLength(20)])],
        'pincode': ['', Validators.compose([Validators.required, Validators.maxLength(6)])]
    });

    this.label = this.authForm.controls['label'];
    this.fname = this.authForm.controls['fname'];
    this.lname = this.authForm.controls['lname'];
    this.address1 = this.authForm.controls['address_line_1'];
    this.address2 = this.authForm.controls['address_line_2'];     
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
    
  }

  itemSelected() {
    this.contents.forEach(function(area) {
      if(area.id == this.area) {
        this.area_city = area.city;
        this.area_state = area.state;
        this.area_pincode = area.pincode;
      }
    }, this);
  }

  onSubmit(value) {
        
      this.loading.show();
      
      var user_id = 0;
      this.local.get('UserId').then((result) => {
          if(result) {
              user_id = result;
          }
    
          this.service.addAddress(user_id, this.area, value).subscribe(data => {
              console.log(data.status);
              this.loading.hide();
              if(data.status == 'false') {
                  var alert = Alert.create({
                      title: 'ERROR!',
                      message: data.msg,
                      buttons: ['Ok']
                  });
                  this.nav.present(alert);
              } else {
                  this.nav.push(HomePage);
              }
          });
      });
  }
}
