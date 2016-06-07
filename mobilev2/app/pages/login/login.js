import {IonicApp, Page, Alert, NavController, Storage, LocalStorage} from 'ionic-angular';
import {Services} from '../../providers/services/services';
import {HomePage} from '../home/home';
import { Component } from 'angular2/core';  
import { FORM_DIRECTIVES, FormBuilder, ControlGroup, Validators, AbstractControl } from 'angular2/common';

/*
  Generated class for the LoginPage page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Page({
    templateUrl: 'build/pages/login/login.html',
    directives: [FORM_DIRECTIVES]
})
export class LoginPage {
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
            'username': ['', Validators.compose([Validators.required, Validators.minLength(8)])],
            'password': ['', Validators.compose([Validators.required, Validators.minLength(8)])]
      });
 
      this.username = this.authForm.controls['username'];     
      this.password = this.authForm.controls['password']; 
  }

    onSubmit(value) {
        
        this.loading.show();
        
        this.service.loginToApp(value).subscribe(data => {
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
                this.local.set('UserId', data.data.user_details.id);
                this.nav.push(HomePage);
            }
        });
    }
    
}
