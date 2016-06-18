import {Page, Alert, NavController, NavParams} from 'ionic-angular';
import {Services} from '../../providers/services/services';
import {SQLite} from '../../providers/sqlite/sqlite';
import {CartPage} from '../cart/cart';

/*
  Generated class for the DetailPage page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Page({
  templateUrl: 'build/pages/detail/detail.html',
})
export class DetailPage {
  static get parameters() {
    return [[Services], [NavController], [NavParams], [SQLite]];
  }

  constructor(service, nav, navParams, sqlite) {
    this.nav = nav;
    
    this.service = service;

    this.sqlite = sqlite;
    
    this.content = navParams.get('content');

    this.content.quantity = 1;

    this.quantityUpdated(this.content);

    this.cart = 0;
      this.sqlite.getKey('Cart').then((result) => {
        if(result) {
            console.log(result);
            this.cart = result;

            /*this.sqlite.getCart(this.cart).then((data) => {
                console.log(data.res.rows.item(0));
            });*/
        }
      });
  }

  quantityUpdated(content) {
        content.quantities.forEach(function(qty) {
            if(qty.id == content.quantity) {
                content.price = qty.price;
            }
        });
    }

    saveToCart() {

      var content = this.content;

        var user_id = 0;
        this.sqlite.getKey('UserId').then((value) => {
            if(value) {
                user_id = value;
            }

            this.service.addToCart(content.id, user_id, this.cart, content.quantity).subscribe(data => {
                console.log(data.status);
                if(data.status == 'false') {
                    var alert = Alert.create({
                        title: 'ERROR!',
                        message: data.msg,
                        buttons: ['Ok']
                    });
                    this.nav.present(alert);
                } else {

                    this.sqlite.getCart(data.cart).then((cart_data) => {
                        var cart_detail = JSON.stringify(cart_data.res);

                        if(!cart_detail.id) {
                            this.sqlite.insertCart(data).then((idata) => {
                                console.log("Cart Added -> " + JSON.stringify(idata.res));
                            }, (error) => {
                                console.log("ERROR -> " + JSON.stringify(error.err));
                            });
                        }

                        this.sqlite.setKey('Cart', data.cart);
                        this.nav.push(CartPage);
                    }, (error) => {
                        console.log("ERROR -> " + JSON.stringify(error.err));
                    });
                }
            });
        });
    }
}
