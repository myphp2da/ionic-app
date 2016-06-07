import {IonicApp, Page, Alert, NavController, Loading, Storage, LocalStorage} from 'ionic-angular';
import {Services} from '../../providers/services/services';
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
    return [[IonicApp], [Services], [NavController]];
  }

  constructor(app, service, nav) {
      
      this.loading = app.getComponent('loading');

      this.nav = nav;
      this.service = service;
      
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

      this.local = new Storage(LocalStorage);

      this.quantity = 0;
      
      this.cart = 0;
  }

    viewCart() {
        this.nav.push(CartPage);
    }
    
    itemTapped(event, content) {

        this.nav.push(DetailPage, {
            content: content
        });

    }

    saveToCart(item_id) {
        
        this.local.get('CartId').then((result) => {
            if(result) {
                this.cart = result;
            }
        });

        var user_id = 0;
        this.local.get('UserId').then((value) => {
            if(value) {
                user_id = value;
            }

            this.service.addToCart(item_id, user_id, this.cart, this.quantity).subscribe(data => {
                console.log(data.status);
                if(data.status == 'false') {
                    var alert = Alert.create({
                        title: 'ERROR!',
                        message: data.msg,
                        buttons: ['Ok']
                    });
                    this.nav.present(alert);
                } else {
                    this.local.set('CartId', data.cart);
                    this.nav.push(CartPage);
                }
            });
        });
    }
}
