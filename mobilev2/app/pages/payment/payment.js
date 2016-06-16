import {Page, NavController} from 'ionic-angular';
import {SQLite} from '../../providers/sqlite/sqlite';
import {Services} from '../../providers/services/services';
import {ConfirmPage} from '../confirm/confirm';

/*
  Generated class for the PaymentPage page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Page({
  templateUrl: 'build/pages/payment/payment.html',
})
export class PaymentPage {
  static get parameters() {
    return [[NavController], [SQLite], [Services]];
  }

  constructor(nav, sqlite, service) {
    this.nav = nav;

    this.sqlite = sqlite;

    this.service = service;

    this.cart = 0;
    this.sqlite.getKey('Cart').then((value) => {
      if(value) {
        this.cart = value;
      }
    });

    this.user = 0;
    this.sqlite.getKey('UserId').then((value) => {
      if(value) {
        this.user = value;
      }
    });

    this.options = [
      { type: 'cod', label: 'Cash on Delivery'},
    ];
  }

  confirmOrder() {
    this.sqlite.updateCart('tinStatus', 1, this.cart);
    this.sqlite.getCart(this.cart).then((data) => {
        var cart_details = data.res.rows.item(0);
        this.service.completeOrder(this.user, cart_details).then((response) => {
          console.log(response.status);
          if(response.status == 'false') {
              var alert = Alert.create({
                  title: 'ERROR!',
                  message: response.msg,
                  buttons: ['Ok']
              });
              this.nav.present(alert);
          } else {
            this.nav.setRoot(ConfirmPage, cart_details);
          }
        });
    });
  }

  setPayment(payment) {
    this.sqlite.updateCart('strPayment', payment, this.cart);
  }
}
