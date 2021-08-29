import  React,{useEffect,useState} from 'react';
import api from "../../services/Api";

function Home() {

    const [data, setData] = useState({})

    const handleGetData = async () =>{
        try{
            const response = await  api.get('/');
            if(response.status === 200){
                 setData(response.data)
            }
        }catch (error) {
            console.log(error.message)
        }
    }

    useEffect(async () =>{
       await handleGetData();
    },[]);
    return (
        <div>
            <h1>{data.toString()}</h1>
        </div>
    )
}
export default Home;