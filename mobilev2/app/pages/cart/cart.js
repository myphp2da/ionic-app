import {IonicApp, Page, Alert, NavController, Storage, LocalStorage} from 'ionic-angular';
import {Services} from '../../providers/services/services';
import {SQLite} from '../../providers/sqlite/sqlite';
import {DeliveryPage} from '../delivery/delivery';
import {DetailPage} from '../detail/detail';

/*
  Generated class for the CartPage page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Page({
  templateUrl: 'build/pages/cart/cart.html',
})
export class CartPage {
  static get parameters() {
      return [[IonicApp], [Services], [NavController], [SQLite]];
  }

  constructor(app, service, nav, sqlite) {
      
      this.loading = app.getComponent('loading');
      this.loading.show();
      
      this.nav = nav;

      this.hasProducts = false;
      
      this.total_amount = 0;
      this.pay_amount = 0;
      
      this.service = service;

      this.sqlite = sqlite;

      this.cart = 0;
      
      sqlite.getKey('Cart').then((value) => {

          if(value) {

            this.cart = value;
          
            service.loadCart(value).subscribe(data => {
                this.loading.hide();
                if(data.status == 'false') {
                    var alert = Alert.create({
                        title: 'ERROR!',
                        message: data.msg,
                        buttons: ['Ok']
                    });
                    this.nav.present(alert);                    
                } else {
                    this.contents = data.data;
                    this.total_amount = data.total_amount;
                    this.pay_amount = this.total_amount + 45;
                    this.hasProducts = true;

                    sqlite.updateCartDetails({
                        'id': this.cart,
                        'total_amount': this.total_amount,
                        'delivery': 45,
                        'products': this.contents.length
                    });
                }
            });
          } else {
              this.loading.hide();
              this.hasProducts = false;
          }
      });
  }
  
  itemTapped(event, content) {

    this.nav.push(DetailPage, {
        content: content
    });

  }
  
  increment(event, content) {
      if(content.quantity < 20) {
        content.quantity = parseInt(content.quantity) + 1;
        content.total_price = Math.round(content.quantity * content.price * 100)/100;
        this.updateCart(content);
      } else {
        var alert = Alert.create({
            title: 'ERROR!',
            message: 'Cannot add more than 20 qunatities',
            buttons: ['Ok']
        });
        this.nav.present(alert);
      }
  }
  
  decrement(event, content) {
      if(content.quantity != 1) {
        content.quantity = parseInt(content.quantity) - 1;
        content.total_price = Math.round(content.quantity * content.price * 100)/100;
        this.updateCart(content);
      }
  }
  
  updateCart(content) {
      this.loading.show();
      this.service.updateCart(this.cart, content).subscribe(data => {
            console.log(data.status);
            this.loading.hide();
            if(data.status == 'false') {
                var alert = Alert.create({
                    title: 'ERROR!',
                    message: data.msg,
                    buttons: ['Ok']
                });
                this.nav.present(alert);
            }
      });
      
      var total_amount = 0;
      this.contents.forEach(function(item) {
        total_amount += item.quantity * item.price;
      });
      this.total_amount = Math.round(total_amount*100)/100;
      this.pay_amount = this.total_amount + 45;

      this.sqlite.updateCart('decAmount', this.total_amount, this.cart);
  }
  
  checkoutCart() {
      this.nav.push(DeliveryPage, {'cart': this.cart});
  }
}