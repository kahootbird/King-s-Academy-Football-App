package football.thekingsacademy.net.kingsacademyfootball;

import android.app.ListActivity;
import android.app.Notification;
import android.content.Context;
import android.os.AsyncTask;
import android.support.annotation.LayoutRes;
import android.support.annotation.NonNull;
import android.support.annotation.Nullable;
import android.support.v7.app.ActionBarActivity;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ListView;
import android.widget.TextView;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.ArrayList;
import java.util.List;

import android.widget.ArrayAdapter;
import android.widget.Toast;

public class team_schedule extends ActionBarActivity {
    private TextView tvData;
    public  String[] myItems;
    ArrayAdapter<String> adapter;

    ListView listView;
    private String[] names = {"name1", "name2", "name3"};
    @Override
    protected void onCreate(Bundle savedInstanceState) {


        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_notifications);

        listView = (ListView)findViewById(R.id.listView1);
        listView.setAdapter(new ArrayAdapter<String>(this,android.R.layout.simple_list_item_1,new ArrayList<String>()));

        //new JSONTask().execute("https://jsonparsingdemo-cec5b.firebaseapp.com/jsonData/moviesDemoList.txt");
        new JSONTask().execute("http://ip_addr/fcmtest/schedule_view.php");

        //Button btnHit = (Button) findViewById(R.id.btnHit);
        //tvData = (TextView) findViewById(R.id.tvJsonItem);
        //tvData = (TextView)findViewById(R.id.tvJsonItem)
        //btnHit.setOnClickListener(new View.OnClickListener() {
/*
            @Override
            public void onClick(View v) {

                //new JSONTask().execute("https://jsonparsingdemo-cec5b.firebaseapp.com/jsonData/moviesDemoList.txt");
                new JSONTask().execute("http://ip_addr/fcmtest/events_view.php");
            }
        });
        */
        //new JSONTask().execute("http://ip_addr/fcmtest/events_view.php");
/*
        String[] myItems = {"Blue", "Green", "Purple", "Red"};

        ListView listView = (ListView)findViewById(R.id.listView1);
        ArrayAdapter<String> adapter = new ArrayAdapter<String>(listView.getContext(), android.R.layout.simple_list_item_1, myItems);

        listView.setAdapter(adapter);
  */
        //ArrayAdapter<String> adapter = new ArrayAdapter<String>(getListView().getContext(), android.R.layout.simple_list_item_1, myItems);

        // getListView().setAdapter(adapter);
    }



    public class JSONTask extends AsyncTask<String, String, String> {
        ArrayAdapter<String> adapter;
        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            adapter = (ArrayAdapter<String>)listView.getAdapter();
        }

        @Override
        protected void onProgressUpdate(String... values) {
            super.onProgressUpdate(values);
            adapter.add(values[0]);

        }

        @Override
        protected String doInBackground(String... params) {

            for (String Name : names)
            {
                publishProgress(Name);
            }


            HttpURLConnection connection = null;
            BufferedReader reader = null;
            try {
                URL url = new URL(params[0]);
                connection = (HttpURLConnection) url.openConnection();
                connection.connect();

                InputStream stream = connection.getInputStream();

                reader = new BufferedReader(new InputStreamReader(stream));
                String line = "";
                StringBuffer buffer = new StringBuffer();
                while ((line = reader.readLine()) != null) {
                    buffer.append(line);
                }
                //PARSE JSON HERE*********************************
                String finalJson = buffer.toString();

                JSONObject parentObject = new JSONObject(finalJson);
                JSONArray parentArray = parentObject.getJSONArray("movies");
                String year;
                StringBuffer finalBufferedData = new StringBuffer();

                for(int i=0; i < parentArray.length(); i++) {

                    JSONObject finalObject = parentArray.getJSONObject(i);
                    String movieName = finalObject.getString("movie");
                    //year = finalObject.getInt("year");
                    year = finalObject.getString("year");
                    finalBufferedData.append(movieName + " * " + year + "\n");
                    //myItems[i] = movieName + " * " + year + "\n";
                }
                //******************************
                return finalBufferedData.toString();

                //return buffer.toString();
            } catch (MalformedURLException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            } catch (JSONException e) {
                e.printStackTrace();
            } finally {
                if (connection != null) {
                    connection.disconnect();
                }
                try {
                    if (reader != null) {
                        reader.close();
                    }
                } catch (IOException e) {
                    e.printStackTrace();
                }

            }
            return "Unable to load - your connection is disabled or the server is down.";
        }

        @Override
        protected void onPostExecute(String result) {
            //this.
            super.onPostExecute(result);
            //MainActivity.tvData.setText(result);

            ///Toast.makeText(getApplicationContext(),result,Toast.LENGTH_LONG).show();
            String[] itemz = {result};

            listView = (ListView)findViewById(R.id.listView1);
            ArrayAdapter<String> adapter = new ArrayAdapter<String>(listView.getContext(), android.R.layout.simple_list_item_1, itemz);


            listView.setAdapter(adapter);
            //tvData.setText(result);
            //Notifications.settext("hi");
            //tvData = (TextView) findViewById(R.id.tvJsonItem);
            //TextView txt = (TextView) findViewById(R.id.tvJsonItem);
            //txt.setText("Executed");
        }
    }

}
