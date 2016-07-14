import {IonicApp, Page, Alert, NavParams, NavController} from 'ionic-angular';
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
    return [[IonicApp], [Services], [NavController], [SQLite], [NavParams]];
  }

  constructor(app, service, nav, sqlite, params) {

    this.loading = app.getComponent('loading');  
    this.loading.show();

    this.nav = nav;

    this.sqlite = sqlite;

    this.contents = [];

    this.delivery = 0;

    this.itemAvailable = false;

    this.cart = params.get('cart');

    this.sqlite.getKey('UserId').then((value) => {
        this.user = value;        
    });

    this.sqlite.getDeliveryAddresses('').then((result) => {
        this.loading.hide();
        if(result) {
            if(result.res.rows.length > 0) {
                for(var i = 0; i < result.res.rows.length; i++) {
                  var row = result.res.rows.item(i);
                  this.contents.push(row);
                }
            }
            this.itemAvailable = true;
        }
    });
  }

  gotoAddressForm(id) {
    this.nav.push(AddressPage, {address: id});
  }

  gotoSlots() {
    if(this.delivery == 0) {
      var alert = Alert.create({
          title: 'ERROR!',
          message: 'Please select delivery address',
          buttons: ['Ok']
      });
      this.nav.present(alert);
    } else {
      this.nav.push(SlotPage, {'cart': this.cart});
    }
  }

  setDelivery(address) {
    this.sqlite.updateCart('idAddress', address, this.cart);
  }
}
