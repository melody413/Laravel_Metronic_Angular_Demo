import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EditLabComponent } from './edit-lab.component';

describe('EditLabComponent', () => {
  let component: EditLabComponent;
  let fixture: ComponentFixture<EditLabComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [EditLabComponent]
    });
    fixture = TestBed.createComponent(EditLabComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
