import {IonicApp, Page, Alert, NavController, NavParams} from 'ionic-angular';
import {Services} from '../../providers/services/services';
import {SQLite} from '../../providers/sqlite/sqlite';
import {HomePage} from '../home/home';

/*
  Generated class for the ConfirmPage page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Page({
  templateUrl: 'build/pages/confirm/confirm.html',
})
export class ConfirmPage {
  static get parameters() {
    return [[IonicApp], [NavController], [NavParams], [Services], [SQLite]];
  }

  constructor(app, nav, params, service, sqlite) {

    this.loading = app.getComponent('loading');

    this.nav = nav;

    this.cart = params.get('cart');

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
                    this.hasProducts = false;
                } else {
                    this.contents = data.data;
                    this.total_amount = data.total_amount;
                }
            });
          } else {
              this.cart = 0;
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

  continueShopping() {
    this.nav.setRoot(HomePage);
  }
}
