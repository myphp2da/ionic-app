import {Injectable} from 'angular2/core';
import {Http} from 'angular2/http';
import 'rxjs/add/operator/map';

/*
  Generated class for the Services provider.

  See https://angular.io/docs/ts/latest/guide/dependency-injection.html
  for more info on providers and Angular 2 DI.
*/
@Injectable()
export class Services {
  static get parameters(){
    return [[Http]]
  }  

  constructor(http) {
    this.http = http;
    this.data = null;

      this.baseUrl = 'http://www.appdemo.co.in/myvegs/'
      this.key = 'ca966ceb77c7ef7';
  }

	loginToApp(username, password) {
        var url = this.baseUrl+'account/0.1/app-login';
		var post_data = JSON.stringify({key: this.key, username: username, password: password});

		return this.http.post(url, post_data).map(res => res.json());
	}

    loadHome() {
        var url = this.baseUrl+'product/0.1/get-products';
        var post_data = JSON.stringify({key: this.key});

        return this.http.post(url, post_data).map(res => res.json());
    }
}

