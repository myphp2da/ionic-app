import {IonicApp, Page, NavParams, NavController} from 'ionic-angular';
import {Services} from '../../providers/services/services';
import {SQLite} from '../../providers/sqlite/sqlite';
import {AddressPage} from '../address/address';
import {SlotPage} from '../slot/slot';

/*
  Generated class for the AddressesPage page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Page({
  templateUrl: 'build/pages/addresses/addresses.html',
})
export class AddressesPage {
  static get parameters() {
    return [[IonicApp], [Services], [NavController], [SQLite], [NavParams]];
  }

  constructor(app, service, nav, sqlite, params) {

    this.loading = app.getComponent('loading');  
    this.loading.show();

    this.nav = nav;

    this.sqlite = sqlite;

    var itemAvailable = true;

    this.cart = params.get('cart');

    this.sqlite.getDeliveryAddresses('').then((result) => {
        this.loading.hide();
        if(result.res.rows.length > 0) {
            this.contents = result.res.rows;
        } else {
            this.itemAvailable = false;
        }
    });
  }

  gotoAddressForm(id) {
    this.nav.push(AddressPage, {address: id});
  }

  gotoSlots() {
    this.nav.push(SlotPage, {'cart': this.cart});
  }

  setAddresses(address) {
    this.sqlite.updateCart('idAddress', address, this.cart);
  }
}
