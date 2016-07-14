import {IonicApp, Page, Alert, NavController, NavParams} from 'ionic-angular';
import {PaymentPage} from '../payment/payment';
import {SQLite} from '../../providers/sqlite/sqlite';

/*
  Generated class for the SlotPage page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Page({
  templateUrl: 'build/pages/slot/slot.html',
})
export class SlotPage {
  static get parameters() {
    return [[IonicApp], [NavController], [SQLite], [NavParams]];
  }

  constructor(app, nav, sqlite, params) {

    this.loading = app.getComponent('loading');  
    this.loading.show();

    this.nav = nav;

    this.sqlite = sqlite;

    this.slot = 0;

    this.cart = params.get('cart');

    console.log(this.cart);

    this.slots = [];

    this.sqlite.getSlots().then((result) => {
        this.loading.hide();
        if(result) {
            if(result.res.rows.length > 0) {
                for(var i = 0; i < result.res.rows.length; i++) {
                  var row = result.res.rows.item(i);
                  this.slots.push(row);
                }
            }
            this.itemAvailable = true;
        }
    });

    var current_date = new Date();

    this.items = [];
    for(let i = 1; i < 3; i++) {
      this.items.push({
        date: current_date.setDate(current_date.getDate() + 1),
        slots: this.slots
      });
    }
  }

  gotoPayment() {
    if(this.slot == 0) {
      var alert = Alert.create({
          title: 'ERROR!',
          message: 'Please select time slot for delivery',
          buttons: ['Ok']
      });
      this.nav.present(alert);
    } else {
      this.nav.push(PaymentPage, {'cart': this.cart});
    }
  }

  setSlot(date, range) {
    this.sqlite.updateCart('strSlot', date+' - '+range, this.cart)
  }
}
