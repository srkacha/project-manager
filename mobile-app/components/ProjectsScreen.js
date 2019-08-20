import React from 'react';
import { StyleSheet, Text, View, Button, Image, TextInput } from 'react-native';
import LoginScreen from './LoginScreen';

const projectsURL = 'https://pisio.etfbl.net/~srdjanj/project-manager/api/projects/get-projects-for-user-id';

export default class ProjectsScreen extends React.Component {

    constructor(props){
      super(props);
      this.state = {
        user: this.props.navigation.getParam('user'),
        projects: []
      };
    }

    static navigationOptions = ({ navigation }) =>{
      return {
        title: 'Projectory',
        headerRight: (
          <View style = {{paddingRight: 20}}><Button title="Logout" color="darkblue"
            onPress={() => navigation.popToTop()}
          /></View>),
          headerLeft: null
      }
  };

    componentWillMount(){
      let formData = new FormData();
      formData.append('user_id', this.state.user.id);

      fetch(projectsURL, {
          method: 'POST',
          headers: {
            Accept: 'application/json',
            'Content-Type': 'multipart/form-data',
          },
          body: formData
      }).then((response) => {
            if(response.status === 200){
                 return response.json();
            }else{
                Alert.alert('Data error', 'There was a problem fetching projects data.');
            }
      }).then(responseJson => {
            alert(responseJson);
      }).catch((error) => alert('There was an error with the request.'));
    }

    componentDidMount(){
    }

    render(){
      return (
        <View>
          <Text>Hello there</Text>
        </View>
      )
    }
  }