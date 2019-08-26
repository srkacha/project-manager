import React from 'react';
import { StyleSheet, Text, View, Button, Image, TextInput, ScrollView } from 'react-native';
import LoginScreen from './LoginScreen';

const projectsURL = 'https://pisio.etfbl.net/~srdjanj/project-manager/api/projects/get-projects-for-user-id';

export default class ProjectsScreen extends React.Component {

    constructor(props){
      super(props);
      this.state = {
        user: this.props.navigation.getParam('user'),
        projects: [],
        loadingDone: false
      };

      this.goToActivity = this.goToActivity.bind(this);
    }

    static navigationOptions = ({ navigation }) =>{
      return {
        title: 'Projects',
        headerRight: (
          <View style = {{paddingRight: 20}}><Button title="Logout" color="#f76c6c"
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
                return Promise.reject();
            }
      }).then(responseJson => {
            this.setState({
              projects: responseJson,
              loadingDone: true
            })
      }).catch((error) => Alert.alert('Data error', 'There was a problem fetching projects data.'));
    }

    componentDidMount(){
    }

    goToActivity(project){
      this.props.navigation.navigate('Activities', {project: project, user: this.state.user });
    }

    render(){
      if(this.state.loadingDone == false){
        return (<View style = {{backgroundColor: '#a8d0e6', flex: 1}}></View>)
      }else if(this.state.projects.length == 0){
        return (
          <View style = {{alignItems: 'center', paddingTop: 25, backgroundColor: '#a8d0e6', flex: 1}}>
              <Image style = {{width: 250, height: 250}} source = {require('../assets/planning.png')}></Image>
              <Text style = {{width: 250, fontSize: 25, marginTop: 25, textAlign: 'center'}}>{'You are currently not assinged on any projects.'}</Text>
          </View>
        );
      }else 
      return (
        <ScrollView style = {styles.projectsView}>
          {
            this.state.projects.map(project => (
              <View key = {project.id} style = {styles.projectCard}>
                <View style = {{padding: 10, backgroundColor: 'white', borderRadius: 5, width: '40%'}}>
                  <Image style = {styles.cardImage} source = {require('../assets/planning.png')}></Image>
                </View>
                <View style = {styles.cardInfo}>
                  <Text style = {{fontSize: 25, marginBottom: 10, color: 'white'}}>{project.name}</Text>
                  <Text style = {{marginBottom: 10, color: 'white'}}>{project.description}</Text>
                  <Button title = 'Activities' color = '#f76c6c' onPress = {() => {this.goToActivity(project)}}></Button>
                </View>
              </View>
            ))
          } 
        </ScrollView>
      )
    }
  }

  const styles = StyleSheet.create({
    title: {
      fontSize: 30, 
      fontWeight: 'bold',
      textAlign: 'center', 
      marginBottom: 25
    },
    projectsView: {
      padding:10,
      backgroundColor: '#a8d0e6',
      flex: 1
    },
    projectCard: {
      display: 'flex',
      flexDirection: 'row',
      flex: 1,
      marginBottom: 10,
      padding: 10,
      borderColor: 'lightgray',
      borderWidth: 1,
      borderRadius: 10,
      backgroundColor: '#374785'
    },
    cardImage: {
      height: 150,
      width: '100%',
      backgroundColor: 'white'
    },
    cardInfo: {
      padding: 10,
      textAlign: 'center',
      fontSize: 25,
      width: '60%'
    }
  });