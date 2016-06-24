import {IonicApp, Page, Alert, NavParams, NavController, Loading, Storage, SqlStorage} from 'ionic-angular';
import {Services} from '../../providers/services/services';
import {SQLite} from '../../providers/sqlite/sqlite';
import {CartPage} from '../cart/cart';
import {SearchPage} from '../search/search';
import {DetailPage} from '../detail/detail';

/*
  Generated class for the ProductsPage page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Page({
  templateUrl: 'build/pages/products/products.html',
})
export class ProductsPage {
  static get parameters() {
    return [[IonicApp], [Services], [NavController],[SQLite], [NavParams]];
  }

  constructor(app, service, nav, sqlite, params) {
      
      this.loading = app.getComponent('loading');

      this.nav = nav;
      this.service = service;

      this.category = params.get('category');

      this.sqlite = sqlite;

      this.hasProducts = true;
      
      this.loading.show();

	  service.loadProducts(this.category).subscribe(data => {
		  console.log(data.msg);
          
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

              if(this.contents) {
                this.contents.forEach(function(item) {
                    item.quantity = (!item.quantity) ? 1 : item.quantity;
                    this.quantityUpdated(item);
                }, this);
              } else {
                  this.hasProducts = false;
              }
		  }
	  });
      
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

      this.user_image = 'images/profile.jpg';
      this.sqlite.getUser().then((result) => {
          this.user = result.res.rows.item(0);
          console.log(this.user.strName);
          if(this.user.strImageName != null) {
              this.user_image = this.service.baseUrl + 'file-manager/customers/' + this.user.strImageName;
          }
      }, (error) => {
          console.log(error);
      });
  }

    quantityUpdated(content) {
        content.quantities.forEach(function(qty) {
            if(qty.id == content.quantity) {
                content.price = qty.price;
            }
        });
    }

    viewCart() {
        this.nav.push(CartPage, {cart: this.cart});
    }

    gotoSearch() {
        this.nav.setRoot(SearchPage);
    }
    
    itemTapped(event, content) {

        this.nav.push(DetailPage, {
            content: content
        });

    }

    saveToCart(content) {

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

                    this.cart = data.cart;
                    this.sqlite.setKey('Cart', data.cart);
                    this.nav.push(CartPage, {'cart': this.cart});
                }
            });
        });
    }
}
