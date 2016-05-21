import {Page, Alert, NavController, Loading} from 'ionic-angular';
import {Services} from '../../providers/services/services';
import {TabsPage} from '../tabs/tabs';

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
    return [[Services], [NavController]];
  }

  constructor(service, nav) {

      this.nav = nav;

	  service.loadHome().subscribe(data => {
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

		  }
	  });
  }

    cart() {
        this.nav.push(TabsPage);
    }
}
