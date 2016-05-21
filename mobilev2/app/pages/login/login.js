import {Page, Alert, NavController, Storage, LocalStorage} from 'ionic-angular';
import {Services} from '../../providers/services/services';
import {HomePage} from '../home/home';

/*
  Generated class for the LoginPage page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Page({
    templateUrl: 'build/pages/login/login.html',
})
export class LoginPage {
  static get parameters() {
    return [[Services], [NavController]];
  }

  constructor(service, nav) {

      this.data = {};
      this.data.username = '';
      this.data.response = '';

      this.service = service;
      this.nav = nav;
      this.local = new Storage(LocalStorage);
  }

    submit() {
        this.service.loginToApp(this.data.username, this.data.password).subscribe(data => {
            console.log(data.status);
            if(data.status == 'false') {
                var alert = Alert.create({
                    title: 'ERROR!',
                    message: data.msg,
                    buttons: ['Ok']
                });
                this.nav.present(alert);
            } else {
                this.local.set('UserId', data.data.user_details.id);
                this.nav.push(HomePage);
            }
        });
    }
}
