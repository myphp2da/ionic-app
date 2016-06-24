import {Page, NavController, NavParams} from 'ionic-angular';
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
    return [[NavController], [SQLite], [NavParams]];
  }

  constructor(nav, sqlite, params) {
    this.nav = nav;

    this.sqlite = sqlite;

    this.cart = params.get('cart');

    this.slots = [
      { time: '12:00', range: '7:00 AM to 12:00 Noon'},
      { time: '17:00', range: '12:00 Noon to 5:00 PM'},
      { time: '21:00', range: '5:00 PM to 9:00 PM'},
    ];

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
    this.nav.push(PaymentPage, {'cart': this.cart});
  }

  setSlot(date, range) {
    this.sqlite.updateCart('strSlot', date+' - '+range, this.cart)
  }
}
