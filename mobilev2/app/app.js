import {App, Platform, Storage, LocalStorage, IonicApp, MenuController} from 'ionic-angular';
import {StatusBar} from 'ionic-native';
import {MainPage} from './pages/main/main';
import {HomePage} from './pages/home/home';
import {IntroPage} from './pages/intro/intro';
import {AccountPage} from './pages/account/account';
import {Services} from './providers/services/services';
import {LoadingModal} from './components/loading-modal/loading-modal';

@App({
  templateUrl: 'build/app.html',
  providers: [Services],
  directives: [LoadingModal],
  config: {} // http://ionicframework.com/docs/v2/api/config/Config/
})
export class MyApp {
  static get parameters() {
    return [[Platform], [IonicApp], [MenuController]];
  }

  constructor(platform, app, menu) {

      this.platform = platform;
      this.menu = menu;
      this.app = app;

      this.initializeApp();

      this.local = new Storage(LocalStorage);

      this.localStorage();

      this.pages = [
          { title: 'Home', component: HomePage },   
          { title: 'My Account', component: AccountPage },
          { title: 'Intro', component: IntroPage }
      ];
  }

    localStorage() {

        this.local.get('IntroShown').then((result) => {
            if(result) {
                this.local.get('UserId').then((result) => {
                    if(result) {
                        this.rootPage = HomePage;
                    } else {
                        this.rootPage = MainPage;
                    }
                });
            } else {
                this.local.set('IntroShown', true);
                this.rootPage = IntroPage;
            }
        });
    }

    initializeApp() {
        this.platform.ready().then(() => {
            // Okay, so the platform is ready and our plugins are available.
            // Here you can do any higher level native things you might need.
            StatusBar.styleDefault();
        });
    }

    // this function will come handy in template
    // It handles the changing of pages via the sidemenu
    // Without this function, all the tantrum we threw above are useless
    openPage(page) {
        this.menu.close()
        let nav = this.app.getComponent('nav');
        nav.setRoot(page.component);
    }
}
