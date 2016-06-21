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
            this.sqlite.getCart(result).then((response) => {
                if(response.res.rows.length > 0) {
                    this.cart = result;
                } else {
                    this.sqlite.removeKey('Cart');
                }
            });
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

                    if(this.cart == 0) {
                        this.sqlite.newCart(data);
                    }

                    this.sqlite.setKey('Cart', data.cart);
                    this.nav.push(CartPage);
                }
            });
        });
    }
}
