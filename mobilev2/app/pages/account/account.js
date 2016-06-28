import {Page, Storage, LocalStorage, NavController} from 'ionic-angular';
import {MainPage} from '../main/main';
import {AddressesPage} from '../addresses/addresses';
import {AddressPage} from '../address/address';
import {Services} from '../../providers/services/services';
import {SQLite} from '../../providers/sqlite/sqlite';

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
    return [[NavController], [SQLite], [Services]];
  }

  constructor(nav, sqlite, services) {
      this.nav = nav;

      this.sqlite = sqlite;
    
      this.sqlite.getKey('UserId').then((result) => {
          if(!result) {
              this.nav.push(MainPage);
          } else {
              this.sqlite.getUser(result).then((response) => {
                  this.profile = response.res.rows.item(0);

                  this.profile_image = 'images/profile.jpg';
                  if(this.profile.strImageName != null) {
                      this.profile_image = this.profile.strImageName;
                  }
              });
          }
      });
    }

    gotoAddresses() {
        this.nav.push(AddressesPage);
    }

    gotoAddressForm(id) {
        this.nav.push(AddressPage, {address: id});
    }
}
