import { Injectable } from '@angular/core';
import { of, Observable } from 'rxjs';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { UserModel } from '../../models/user.model';
import { environment } from '../../../../../environments/environment';
import { AuthModel } from '../../models/auth.model';

const API_USERS_URL = `${environment.apiUrl}/api`;

@Injectable({
  providedIn: 'root',
})
export class AuthHTTPService {
  private _token: string;
  private authLocalStorageToken = `${environment.appVersion}-${environment.USERDATA_KEY}`;
  constructor(private http: HttpClient) {}

  // public methods
  login(email: string, password: string): Observable<any> {
      return this.http.post<any>(`${API_USERS_URL}/login`, {
        email,
        password,
      });
  }

  // CREATE =>  POST: add a new user to the server
  createUser(user: UserModel): Observable<UserModel> {
    return this.http.post<UserModel>(API_USERS_URL, user);
  }

  // Your server should check email => If email exists send link to the user and return true | If email doesn't exist return false
  forgotPassword(email: string): Observable<boolean> {
    return this.http.post<boolean>(`${API_USERS_URL}/forgot-password`, {
      email,
    });
  }

  getUserByToken(token: string): Observable<any> {
    const user = 
    {
      id: 1,
      username: 'admin',
      password: 'demo',
      email: 'admin@demo.com',
      authToken: 'auth-token-8f3ae836da744329a6f93bf20594b5cc',
      refreshToken: 'auth-token-f8c137a2c98743f48b643e71161d90aa',
      roles: [1], // Administrator
      pic: './assets/media/avatars/300-1.jpg',
      fullname: 'Sean S',
      firstname: 'Sean',
      lastname: 'Stark',
      occupation: 'CEO',
      companyName: 'Keenthemes',
      phone: '456669067890',
      language: 'en',
      timeZone: 'International Date Line West',
      website: 'https://keenthemes.com',
      emailSettings: {
        emailNotification: true,
        sendCopyToPersonalEmail: false,
        activityRelatesEmail: {
          youHaveNewNotifications: false,
          youAreSentADirectMessage: false,
          someoneAddsYouAsAsAConnection: true,
          uponNewOrder: false,
          newMembershipApproval: false,
          memberRegistration: true,
        },
        updatesFromKeenthemes: {
          newsAboutKeenthemesProductsAndFeatureUpdates: false,
          tipsOnGettingMoreOutOfKeen: false,
          thingsYouMissedSindeYouLastLoggedIntoKeen: true,
          newsAboutMetronicOnPartnerProductsAndOtherServices: true,
          tipsOnMetronicBusinessProducts: true,
        },
      },
      communication: {
        email: true,
        sms: true,
        phone: false,
      },
      address: {
        addressLine: 'L-12-20 Vertex, Cybersquare',
        city: 'San Francisco',
        state: 'California',
        postCode: '45000',
      },
      socialNetworks: {
        linkedIn: 'https://linkedin.com/admin',
        facebook: 'https://facebook.com/admin',
        twitter: 'https://twitter.com/admin',
        instagram: 'https://instagram.com/admin',
      },
    };
    const lsValue = localStorage.getItem(this.authLocalStorageToken);
    if (!lsValue) {
      return of(user);
    }
    const authData = JSON.parse(lsValue);
    user.email = authData.email;
    user.authToken = authData.token;
    
    return of(user);
  }
}
