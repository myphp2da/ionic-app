import {Page, Storage, LocalStorage, NavController} from 'ionic-angular';
import {MainPage} from '../main/main';

/*
  Generated class for the MyAccountPage page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Page({
  templateUrl: 'build/pages/account/account.html',
})
export class AccountPage {
  static get parameters() {
    return [[NavController]];
  }

  constructor(nav) {
    this.nav = nav;
    
    this.local = new Storage(LocalStorage);
    
    this.local.get('UserId').then((result) => {
        if(!result) {
            this.nav.push(MainPage);
        }
    });
  }
}
