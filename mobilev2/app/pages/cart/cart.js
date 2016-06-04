import {Page, NavController, Storage, LocalStorage} from 'ionic-angular';
import {Services} from '../../providers/services/services';

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
      return [[Services], [NavController]];
  }

  constructor(service, nav) {
      this.nav = nav;

      this.local = new Storage(LocalStorage);

      var user_id = this.local.get('UserId');
      
      var itemAvailable = false;

      service.loadCart(user_id).subscribe(data => {
          console.log(data.status);
          if(data.status == 'false') {
              var alert = Alert.create({
                  title: 'ERROR!',
                  message: data.msg,
                  buttons: ['Ok']
              });
              this.nav.present(alert);
          } else {
              this.contents = data.data;
              itemAvailable = true;
          }
      });
  }
}
