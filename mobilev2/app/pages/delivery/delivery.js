import {IonicApp, Page, NavController} from 'ionic-angular';
import {Services} from '../../providers/services/services';
import {SQLite} from '../../providers/sqlite/sqlite';
import {AddressPage} from '../address/address';
import {SlotPage} from '../slot/slot';

/*
  Generated class for the DeliveryPage page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Page({
  templateUrl: 'build/pages/delivery/delivery.html',
})
export class DeliveryPage {
  static get parameters() {
    return [[IonicApp], [Services], [NavController], [SQLite]];
  }

  constructor(app, service, nav, sqlite) {

    this.loading = app.getComponent('loading');  
    this.loading.show();

    this.nav = nav;

    this.sqlite = sqlite;

    var itemAvailable = false;

    this.cart = 0;
    this.sqlite.getKey('Cart').then((value) => {
      if(value) {
        this.cart = value;
      }
    });

    this.sqlite.getKey('UserId').then((value) => {
          
        this.user = value;
          
        console.log('User: '+value);

        service.loadAddresses(value).subscribe(data => {
            console.log(data.status);
            this.loading.hide();
            if(data.status == 'true') {
                this.contents = data.data;
                itemAvailable = true;
            }
        });
    });
  }

  gotoAddressForm(id) {
    this.nav.push(AddressPage, {address: id});
  }

  gotoSlots() {
    this.nav.push(SlotPage);
  }

  setDelivery(address) {
    this.sqlite.updateCart('idAddress', address, this.cart);
  }
}
