import {IonicApp, Page, Alert, NavController, Storage, LocalStorage} from 'ionic-angular';
import {Services} from '../../providers/services/services';
import {HomePage} from '../home/home';
import { Component } from 'angular2/core';
import { FORM_DIRECTIVES, FormBuilder, ControlGroup, Validators, AbstractControl } from 'angular2/common';

/*
  Generated class for the SignupPage page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Page({
  templateUrl: 'build/pages/signup/signup.html',
  directives: [FORM_DIRECTIVES]
})
export class SignupPage {
  static get parameters() {
    return [[IonicApp], [Services], [NavController], [FormBuilder]];
  }

  constructor(app, service, nav, fb) {
    
    this.loading = app.getComponent('loading');

    this.data = {};
    this.data.username = '';
    this.data.response = '';

    this.service = service;
    this.nav = nav;
    this.local = new Storage(LocalStorage);
    
    this.authForm = fb.group({
        'fname': ['', Validators.compose([Validators.required, Validators.maxLength(20)])],
        'lname': ['', Validators.compose([Validators.required, Validators.maxLength(20)])],
        'phone': ['', Validators.compose([Validators.required, Validators.maxLength(10), Validators.minLength(10)])],
        'email': ['', Validators.compose([Validators.required, Validators.email])],
        'password': ['', Validators.compose([Validators.required, Validators.minLength(8)])]
    });

    this.fname = this.authForm.controls['fname'];
    this.lname = this.authForm.controls['lname'];
    this.phone = this.authForm.controls['phone'];
    this.email = this.authForm.controls['email'];     
    this.password = this.authForm.controls['password'];
  }
  
  onSubmit(value) {
        
      this.loading.show();
      
      this.service.signupInApp(value).subscribe(data => {
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
              this.local.set('UserId', data.user_id);
              this.nav.push(HomePage);
          }
      });
  }
}
