import {IonicApp, Page, Alert, NavController, Loading, Storage, SqlStorage} from 'ionic-angular';
import {Services} from '../../providers/services/services';
import {SQLite} from '../../providers/sqlite/sqlite';
import {CartPage} from '../cart/cart';
import {DetailPage} from '../detail/detail';

/*
  Generated class for the HomePage page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Page({
  templateUrl: 'build/pages/home/home.html',
})
export class HomePage {
  static get parameters() {
    return [[IonicApp], [Services], [NavController],[SQLite]];
  }

  constructor(app, service, nav, sqlite) {
      
      this.loading = app.getComponent('loading');

      this.nav = nav;
      this.service = service;

      this.sqlite = sqlite;
      
      this.loading.show();

	  service.loadHome().subscribe(data => {
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
		  }
	  });
      
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

    viewCart() {
        this.nav.push(CartPage);
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
