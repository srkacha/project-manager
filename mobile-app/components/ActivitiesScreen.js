import React from 'react';
import { StyleSheet, Text, View, Button, Image, TextInput, Alert, ScrollView } from 'react-native';

const activitiesURL = 'https://pisio.etfbl.net/~srdjanj/project-manager/api/activities/get-activities-for-project-and-user';

export default class ActivitiesScreen extends React.Component{
    constructor(props){
        super(props);
        this.state = {
          user: this.props.navigation.getParam('user'),
          project: this.props.navigation.getParam('project'),
          activities: [],
          loadingDone: false
        };

        this.updateProgress = this.updateProgress.bind(this);
      }
  
      static navigationOptions = ({ navigation }) =>{
        return {
          title: 'Activities',
          headerRight: (
            <View style = {{paddingRight: 20}}><Button title="Logout" color="#1A1A1A"
              onPress={() => navigation.popToTop()}
            /></View>)
        }
      };
  
    componentWillMount(){
      let formData = new FormData();
      formData.append('user_id', this.state.user.id);
      formData.append('project_id', this.state.project.id);

      fetch(activitiesURL, {
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
              activities: responseJson,
              loadingDone: true
            })
      }).catch((error) => Alert.alert('Data error', 'There was a problem fetching activities data.'));
    }

    componentDidMount(){
    }

    updateProgress(){
      this.props.navigation.navigate('Progress', {});
    }

    render(){
      if(this.state.loadingDone == false){
        return (<View></View>);
      }
      else if(this.state.activities.length == 0){
        return (
          <View style = {{alignItems: 'center', paddingTop: 25}}>
              <Image style = {{width: 250, height: 250}} source = {require('../assets/list.png')}></Image>
              <Text style = {{width: 250, fontSize: 25, marginTop: 25, textAlign: 'center'}}>{'No activities for you on the selected project.'}</Text>
          </View>
        );
      }else return (
        <ScrollView style = {styles.projectsView}>
          {
            this.state.activities.map(activity => (
              <View style = {styles.projectCard}>
                <View style = {{padding: 10, backgroundColor: 'white', borderRadius: 5, width: '40%'}}>
                  <Image style = {styles.cardImage} source = {require('../assets/list.png')}></Image>
                </View>
                <View style = {styles.cardInfo}>
                  <Text style = {{fontSize: 25, marginBottom: 10, color: 'white'}}>{activity.description}</Text>
                  <Button title = 'Update progress' color = '#1D2951' onPress = {() => {this.updateProgress()}}></Button>
                </View>
              </View>
            ))
          } 
        </ScrollView>
      );
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
    padding:10
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
    backgroundColor: '#0e4d92'
  },
  cardImage: {
    height: 120,
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