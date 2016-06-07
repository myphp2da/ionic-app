import {Page, NavController} from 'ionic-angular';
import {LoginPage} from '../login/login';
import {SignupPage} from '../signup/signup';

/*
  Generated class for the MainPage page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Page({
  templateUrl: 'build/pages/main/main.html',
})
export class MainPage {
  static get parameters() {
    return [[NavController]];
  }

  constructor(nav) {
    this.nav = nav;
  }

    appLogin() {
        this.nav.push(LoginPage);
    }

    appSignUp() {
        this.nav.push(SignupPage);
    }
}
