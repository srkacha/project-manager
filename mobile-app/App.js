import React from 'react';
import { StyleSheet, Text, View, Button, Image, TextInput } from 'react-native';
import { createStackNavigator, createAppContainer } from 'react-navigation';
import LoginScreen from './components/LoginScreen';
import ProjectsScreen from './components/ProjectsScreen';

//Code responsible for navigation

const MainNavigator = createStackNavigator(
  {
    Login: {screen: LoginScreen},
    Projects: {screen: ProjectsScreen},
  },
  {
    initialRouteName: "Login",
    defaultNavigationOptions: {
      headerStyle: {
        backgroundColor: 'white',
      },
      headerTintColor: 'black',
      headerTitleStyle: {
        fontWeight: 'bold',
      },
    },
  }
);

//Exporting the main app object

const App = createAppContainer(MainNavigator);
export default App;
