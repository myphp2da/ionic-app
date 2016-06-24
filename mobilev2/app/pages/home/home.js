import {IonicApp, Page, Alert, NavController, Loading, Storage, SqlStorage} from 'ionic-angular';
import {Services} from '../../providers/services/services';
import {SQLite} from '../../providers/sqlite/sqlite';
import {CartPage} from '../cart/cart';
import {MainPage} from '../main/main';
import {ProductsPage} from '../products/products';
import {SearchPage} from '../search/search';
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

      this.extraOptions = {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        slidesPerView: 2,
        spaceBetween: 50
      }
      
      this.loading = app.getComponent('loading');

      this.nav = nav;

      this.hasFilter = false;
      
      this.loading.show();

      sqlite.getKey('UserId').then((value) => {
        if(value) {
            
            service.loadHome(value).subscribe(response => {
                this.loading.hide();
                if(response.status == 'false') {
                    var alert = Alert.create({
                        title: 'ERROR!',
                        message: response.msg,
                        buttons: ['Ok']
                    });
                    this.nav.present(alert);
                } else {
                    this.categories = response.data.categories;
                    this.products = response.data.products;

                    sqlite.syncDB(response.data);
                }
            });
            
        } else {
            nav.setRoot(MainPage);
        }
      });
  }

  viewCart() {
        this.nav.push(CartPage);
    }

    gotoSearch() {
        this.nav.push(SearchPage, {user: this.user});
    }
    
    productTapped(event, content) {
        this.nav.push(DetailPage, {
            content: content,
            user: this.user
        });
    }

    categoryTapped(event, category) {
        this.nav.push(ProductsPage, {
            category: category,
            user: this.user
        });
    }
}