import {Storage, SqlStorage} from 'ionic-angular';
import {Injectable} from 'angular2/core';

/*
  Generated class for the Services provider.

  See https://angular.io/docs/ts/latest/guide/dependency-injection.html
  for more info on providers and Angular 2 DI.
*/
@Injectable()
export class SQLite {
  static get parameters(){
    return []
  }  

  constructor() {
    let options = {
        name: 'mvfdb',              // the name of the database
        backupFlag: SqlStorage.BACKUP_LOCAL, // where to store the file
        existingDatabase: false              // load this as an existing database
    };

    this.storage = new Storage(SqlStorage, options);

    //this.clearStorage();
    //this.createStorage();
  }

  clearStorage() {
    let drop_user = 'DROP TABLE IF EXISTS user_details';
    this.storage.query(drop_user);
  }

  updateUser(data) {

      let drop_user = 'DROP TABLE IF EXISTS user_details';
      this.storage.query(drop_user);

      let create_user = 'CREATE TABLE IF NOT EXISTS user_details (id INTEGER PRIMARY KEY, strName VARCHAR(50) NOT NULL, strImageName VARCHAR(100), strEmail VARCHAR(100) NOT NULL)';
      this.storage.query(create_user);

      let sql = "insert into user_details(id, strName, strImageName, strEmail) values (?, ?, ?, ?)";
      return this.storage.query(sql, [data.id, data.strFirstName+' '+data.strLastName, data.strImageName, data.strEmail]);
  }

  updateDeliveryAddresses(data) {
      let drop_address = 'DROP TABLE IF EXISTS delivery_addresses';
      this.storage.query(drop_address);

      let create_address = 'CREATE TABLE IF NOT EXISTS delivery_addresses ('+
                                'id int(11) NOT NULL, '+
                                'strLabel varchar(15) NOT NULL,'+
                                'strName varchar(50) NOT NULL,'+
                                'strAddressLine1 varchar(255) DEFAULT NULL,'+
                                'strAddressLine2 varchar(50) NOT NULL,'+
                                'idArea int(11) NOT NULL,'+
                                'strCity varchar(255) DEFAULT NULL,'+
                                'strState varchar(255) DEFAULT NULL,'+
                                'intPincode int(6) NOT NULL)';
      this.storage.query(create_address);

      let sql = 'insert into delivery_addresses(id, strLabel, strName, strAddressLine1, strAddressLine2, idArea, strCity, strState, intPincode)'+
                                        'values(?, ?, ?, ?, ?, ?, ?, ?, ?)';
      return this.storage.query(sql, [
          data.id, 
          data.label,
          data.name, 
          data.address1, 
          data.address2,
          data.area,
          data.city,
          data.state,
          data.pincode
      ]);
  }

  updateAreas(data) {

      let drop_area = 'DROP TABLE IF EXISTS areas';
      this.storage.query(drop_area);

      let create_area = 'CREATE TABLE IF NOT EXISTS areas (id INTEGER PRIMARY KEY, strArea VARCHAR(50) NOT NULL, strCity VARCHAR(50) NOT NULL, strState VARCHAR(50) NOT NULL, intPinCode INTEGER(6) NOT NULL)';
      this.storage.query(create_area);

      data.forEach(function(row) {
          let sql = "insert into areas(id, strArea, strCity, strState, intPinCode) values (?, ?, ?, ?, ?)";
          this.storage.query(sql, [row.id, row.name, row.city, row.state, row.pincode]);     
      }, this);
  }

  updateSlots(data) {

      let drop_slot = 'DROP TABLE IF EXISTS slots';
      this.storage.query(drop_slot);

      let create_slot = 'CREATE TABLE IF NOT EXISTS slots (id INTEGER PRIMARY KEY, strSlot VARCHAR(50) NOT NULL)';
      this.storage.query(create_slot);

      data.forEach(function(row) {
          let sql = "insert into slots(id, strSlot) values (?, ?)";
          this.storage.query(sql, [row.id, row.name]);    
      }, this);
  }

  syncDB(data) {
        if(data.slots) {
            this.updateSlots(data.slots);
        }

        if(data.areas) {
            this.updateAreas(data.areas);
        }

        if(data.categories) {
            this.updateCategories(data.categories);
        }
    }

  updateCategories(data) {

      var current_storage = this.storage;

      let drop_category = 'DROP TABLE IF EXISTS categories';
      current_storage.query(drop_category);

      let create_category = 'CREATE TABLE IF NOT EXISTS categories (id INTEGER PRIMARY KEY, strCategory VARCHAR(50) NOT NULL, strImageName VARCHAR(100) NULL, idParent INTEGER DEFAULT 0 NULL)';
      current_storage.query(create_category);

      data.forEach(function(row) {
          let sql = "insert into categories(id, strCategory, strImageName, idParent) values (?, ?, ?, ?)";
          current_storage.query(sql, [row.id, row.name, row.photo, 0]);

          if(row.sub_categories) {
              row.sub_categories.forEach(function(sub_row) {
                let sql = "insert into categories(id, strCategory, strImageName, idParent) values (?, ?, ?, ?)";
                current_storage.query(sql, [sub_row.id, sub_row.name, sub_row.photo, sub_row.parent]);
              });
          }   
      }, this);
  }

  newCart(data) {
    let drop_cart = 'DROP TABLE IF EXISTS cart';
    this.storage.query(drop_cart);

    let create_cart = 'CREATE TABLE IF NOT EXISTS cart(id INTEGER PRIMARY KEY, idAddress INTEGER NULL, strSlot VARCHAR(50) NULL, strPayment VARCHAR(5) NULL, tinStatus TINYINT(1) DEFAULT "0")';
    this.storage.query(create_cart);

    let sql = "insert into cart(id) values (?)";
    return this.storage.query(sql, [data.cart]);
  }

  updateCart(field, value, id) {
      let sql = "update cart set "+field+" = ? where id = ?";
      //console.log(sql + ' - ' + value + ' - ' + id);
      return this.storage.query(sql, [value, id]);
  }

  setKey(key, value) {
      this.storage.set(key, value);
  }

  getKey(key) {
      return this.storage.get(key);
  }

  removeKey(key) {
      return this.storage.remove(key);
  }

  getCart(id) {
      let sql = "select * from cart where id = ?";
      return this.storage.query(sql, [id]);
  }

  getCategories() {
      let sql = "select * from categories order by idParent";
      return this.storage.query(sql);
  }

  getUser() {
      let sql = "select * from user_details limit 1";
      return this.storage.query(sql);
  }
}