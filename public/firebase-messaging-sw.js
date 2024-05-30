// Use importScripts to load Firebase libraries in the service worker
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');

// Import the functions you need from the SDKs you need
// import { initializeApp } from "firebase/app";
// import { getAnalytics } from "firebase/analytics";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: "AIzaSyCNbUGGR0_T9H0m5-ZbbGEj_2mnxJIUynE",
  authDomain: "notification-18293.firebaseapp.com",
  projectId: "notification-18293",
  storageBucket: "notification-18293.appspot.com",
  messagingSenderId: "1085362025681",
  appId: "1:1085362025681:web:dd3dfdfc8aa1d41a6341f0",
  measurementId: "G-H0WKK0Z03R"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);

