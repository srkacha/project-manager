import React from 'react';
import { StyleSheet, Text, View, Button, Image, TextInput } from 'react-native';
import { createStackNavigator, createAppContainer } from 'react-navigation';
import LoginScreen from './components/LoginScreen';
import ProjectsScreen from './components/ProjectsScreen';
import ActivitiesScreen from './components/ActivitiesScreen';
import ProgressScreen from './components/ProgressScreen';

//Code responsible for navigation

const MainNavigator = createStackNavigator(
  {
    Login: {screen: LoginScreen},
    Projects: {screen: ProjectsScreen},
    Activities: {screen: ActivitiesScreen},
    Progress: {screen: ProgressScreen}
  },
  {
    initialRouteName: "Login",
    defaultNavigationOptions: {
      headerStyle: {
        backgroundColor: '#24305e',
      },
      headerTintColor: 'white',
      headerTitleStyle: {
        fontWeight: 'bold',
      },
    },
  }
);

//Exporting the main app object

const App = createAppContainer(MainNavigator);
export default App;
