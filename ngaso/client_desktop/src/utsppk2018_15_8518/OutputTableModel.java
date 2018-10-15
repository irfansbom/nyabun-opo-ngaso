/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package utsppk2018_15_8518;

import java.util.ArrayList;
import javax.swing.table.AbstractTableModel;

/**
 *
 * @author 15.8518
 */
public class OutputTableModel extends AbstractTableModel {

    private ArrayList<User> users;
    private String[] column;

    public OutputTableModel() {
        users = new ArrayList<>();
        column = new String[]{
            "Username",
            "Nama Lengkap",
            "Email"
        };
    }

    @Override
    public int getRowCount() {
        return users.size();
    }

    @Override
    public int getColumnCount() {
        return column.length;
    }

    @Override
    public Object getValueAt(int rowIndex, int columnIndex) {
        switch (columnIndex) {
            case 0: return users.get(rowIndex).getUsername();
            case 1: return users.get(rowIndex).getNamaLengkap();
            case 2: return users.get(rowIndex).getEmail();
        }
        return "";
    }

    @Override
    public String getColumnName(int column) {
        return this.column[column];
    }

    public ArrayList<User> getUsers() {
        return users;
    }

    public void setUsers(ArrayList<User> users) {
        this.users = users;
    }
    
    

}
