import {Page, NavController, Alert, NavParams} from 'ionic-angular';
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
    return [[NavController], [SQLite], [Services], [NavParams]];
  }

  constructor(nav, sqlite, service, params) {
    this.nav = nav;

    this.sqlite = sqlite;

    this.service = service;

    this.payment_option = 0;

    this.cart = params.get('cart');
    
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
    console.log(this.payment_option);
    if(this.payment_option == 0) {
      var alert = Alert.create({
          title: 'ERROR!',
          message: 'Please select payment option to complete the order',
          buttons: ['Ok']
      });
      this.nav.present(alert);
    } else {
      
      this.sqlite.updateCart('tinStatus', 1, this.cart);

      this.sqlite.getCart(this.cart).then((result) => {
          var cart_details = result.res.rows.item(0);
          this.service.completeOrder(this.user, cart_details).subscribe(response => {
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
  }

  setPayment(payment) {
    this.sqlite.updateCart('strPayment', payment, this.cart);
  }
}
